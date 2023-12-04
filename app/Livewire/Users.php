<?php

namespace BDS\Livewire;

use BDS\Events\Auth\RegisteredEvent;
use BDS\Livewire\Forms\UserForm;
use BDS\Livewire\Traits\WithBulkActions;
use BDS\Livewire\Traits\WithCachedRows;
use BDS\Livewire\Traits\WithFilters;
use BDS\Livewire\Traits\WithPerPagePagination;
use BDS\Livewire\Traits\WithSorting;
use BDS\Livewire\Traits\WithToast;
use BDS\Models\Permission;
use BDS\Models\User;
use BDS\Models\Role;
use BDS\Models\Site;
use Carbon\Carbon;
use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Livewire\Component;

class Users extends Component
{
    use AuthorizesRequests;
    use WithBulkActions;
    use WithCachedRows;
    use WithFilters;
    use WithPerPagePagination;
    use WithSorting;
    use WithToast;

    /**
     * Bind the main model used in the component to be used in traits.
     *
     * @var string
     */
    public string $model = User::class;

    /**
     * The form used to create/update a user.
     *
     * @var UserForm
     */
    public UserForm $form;

    /**
     * The field to sort by.
     *
     * @var string
     */
    public string $sortField = 'created_at';

    /**
     * The direction of the ordering.
     *
     * @var string
     */
    public string $sortDirection = 'asc';

    /**
     * Used to update in URL the query string.
     *
     * @var string[]
     */
    protected array $queryString = [
        'sortField' => ['as' => 'f'],
        'sortDirection' => ['as' => 'd'],
        'filters',
    ];

    /**
     * Filters used for advanced search.
     *
     * @var array
     */
    public array $filters = [
        'name' => '',
        'email' => '',
        'role' => '',
        'is_deleted' => '',
        'created_min' => '',
        'created_max' => '',
    ];

    /**
     * Array of allowed fields.
     *
     * @var array
     */
    public array $allowedFields = [
        'id',
        'last_name',
        'email',
        'last_login_date',
        'created_at',
        'deleted_at'
    ];

    /**
     * Used to show the Edit/Create modal.
     *
     * @var bool
     */
    public bool $showModal = false;

    /**
     * Used to show the delete modal.
     *
     * @var bool
     */
    public bool $showDeleteModal = false;

    /**
     * Used to set the modal to Create action (true) or Edit action (false).
     *
     * @var bool
     */
    public bool $isCreating = false;

    /**
     * Number of rows displayed on a page.
     * @var int
     */
    public int $perPage = 15;

    /**
     * Flash messages for the model.
     *
     * @var array
     */
    protected array $flashMessages = [
        'create' => [
            'success' => "L'utilisateur <b>:name</b> a été créé avec succès !",
            'error' => "Une erreur s'est produite lors de la création de l'utilisateur !"
        ],
        'update' => [
            'success' => "L'utilisateur <b>:name</b> a été édité avec succès !",
            'error' => "Une erreur s'est produite lors de l'édition de l'utilisateur !"
        ],
        'delete' => [
            'success' => "<b>:count</b> utilisateur(s) ont été supprimé(s) avec succès !",
            'error' => "Une erreur s'est produite lors de la suppression des utilisateurs !"
        ],
        'restore' => [
            'success' => "L'utilisateur <b>:name</b> a été restauré avec succès !",
            'error' => "Une erreur s'est produite lors de la restauration de l'utilisateur !"
        ]
    ];

    /**
     * Function to generate the username based on the first_name and last_name fields.
     *
     * Format : Emeric.F
     *
     * @return void
     */
    public function generateUsername(): void
    {
        $firstName = Str::slug(trim($this->form->first_name), '');
        $lastName = Str::slug(trim($this->form->last_name), '');

        $this->form->username = $firstName . '.' . $lastName;
    }

    /**
     * Function to render the component.
     *
     * @return View
     */
    public function render(): View
    {
        // Select only the roles attached to this site or the roles without assigned site_id.
        $roles = Role::where('site_id', session('current_site_id'))
            ->orWhereNull('site_id')
            ->where('level', '<=', auth()->user()->level)
            ->select(['id', 'name'])
            ->orderBy('name')
            ->get()
            ->toArray();

        // Select all permissions except `bypass login` who is assigned to the `site_id` 0.
        $permissions = Permission::where('name', '<>', 'bypass login')->select(['id', 'name', 'description'])
            ->orderBy('name')
            ->get()
            ->toArray();

        return view('livewire.users', [
            'users' => $this->rows,
            'roles' => $roles,
            'permissions' => $permissions,
            'site' => Site::find(session('current_site_id'))
        ]);
    }

    /**
     * Create and return the query for the items.
     *
     * @return Builder
     */
    public function getRowsQueryProperty(): Builder
    {
        $query = User::query()
            ->with('roles');

        if (Auth::user()->can('search', User::class)) {
            $query->when($this->filters['name'], fn($query, $search) => $query->where('first_name', 'LIKE', '%' . $search . '%')->orWhere('last_name', 'LIKE', '%' . $search . '%'))
                ->when($this->filters['email'], fn($query, $search) => $query->where('email', 'LIKE', '%' . $search . '%'))
                ->when($this->filters['is_deleted'], function($query, $deleted) {
                    if ($deleted === 'yes') {
                        return $query->whereNotNull('deleted_at');
                    }
                    return $query->whereNull('deleted_at');
                })
                ->when($this->filters['role'], function ($query, $search) {
                    return $query->whereHas('roles', function ($partQuery) use ($search) {
                        $partQuery->where('name', 'LIKE', '%' . $search . '%');
                    });
                })
                ->when($this->filters['created_min'], fn($query, $date) => $query->where('created_at', '>=', Carbon::parse($date)))
                ->when($this->filters['created_max'], fn($query, $date) => $query->where('created_at', '<=', Carbon::parse($date)));
        }
        $query->when($this->sortField == 'created_at', function ($query) {
            return $query->withCount('roles')
                ->orderByDesc('roles_count');
        });
        $query->withTrashed();

        return $this->applySorting($query);
    }

    /**
     * Build the query or get it from the cache and paginate it.
     *
     * @return LengthAwarePaginator
     */
    public function getRowsProperty(): LengthAwarePaginator
    {
        return $this->cache(function () {
            return $this->applyPagination($this->rowsQuery);
        });
    }

    /**
     * Create a blank model and assign it to the model. (Used in create modal)
     *
     * @return void
     */
    public function create(): void
    {
        $this->authorize('create', User::class);

        $this->isCreating = true;
        $this->useCachedRows();

        $this->form->reset();

        $this->showModal = true;
    }

    /**
     * Set the model (used in modal) to the user we want to edit.
     *
     * @param User $user The user id to update.
     * (Livewire will automatically fetch the model by the id)
     *
     * @return void
     */
    public function edit(User $user): void
    {
        $this->authorize('update', $user);

        $this->isCreating = false;
        $this->useCachedRows();

        $roles = $user->roles()->pluck('id')->toArray();
        $permissions = $user->permissions()->pluck('id')->toArray();

        $this->form->setUser($user, $roles, $permissions);

        $this->showModal = true;
    }

    /**
     * Validate and save the model.
     *
     * @return void
     */
    public function save(): void
    {
        $this->isCreating ?
            $this->authorize('create', User::class) :
            $this->authorize('update', $this->form->user);

        $this->validate();

        $model = $this->isCreating ? $this->form->store() : $this->form->update();

        $this->success($this->flashMessages[$this->isCreating ? 'create' : 'update']['success'], ['name' => $model->full_name]);

        if ($this->isCreating === true) {
            event(new RegisteredEvent($model));
        }

        $this->showModal = false;
    }

    /**
     * Restore a model.
     *
     * @return void
     */
    public function restore(): void
    {
        $this->authorize('restore', User::class);

        $this->form->user->restore();

        // Reset the date to null to prevent an automatic delete.
        if (!is_null($this->form->user->end_employment_contract)) {
            $this->form->end_employment_contract = null;

            $this->form->user->end_employment_contract = null;
            $this->form->user->save();
        }
        $this->success($this->flashMessages['restore']['success'], ['name' => $this->form->user->full_name]);
    }
}
