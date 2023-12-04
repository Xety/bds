<?php
namespace BDS\Livewire\Roles;

use BDS\Livewire\Forms\RoleForm;
use BDS\Livewire\Traits\WithBulkActions;
use BDS\Livewire\Traits\WithCachedRows;
use BDS\Livewire\Traits\WithFilters;
use BDS\Livewire\Traits\WithPerPagePagination;
use BDS\Livewire\Traits\WithSorting;
use BDS\Livewire\Traits\WithToast;
use BDS\Models\Permission;
use BDS\Models\Role;
use BDS\Models\Site;
use Carbon\Carbon;
use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Spatie\Permission\PermissionRegistrar;

class Roles extends Component
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
    public string $model = Role::class;

    /**
     * The form used to create/update a user.
     *
     * @var RoleForm
     */
    public RoleForm $form;

    /**
     * The field to sort by.
     *
     * @var string
     */
    public string $sortField = 'level';

    /**
     * The direction of the ordering.
     *
     * @var string
     */
    public string $sortDirection = 'desc';

    /**
     * Used to update in URL the query string.
     *
     * @var array
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
        'description' => '',
        'level_min' => '',
        'level_max' => '',
        'created_min' => '',
        'created_max' => ''
    ];

    /**
     * Array of allowed fields.
     *
     * @var array
     */
    public array $allowedFields = [
        'id',
        'name',
        'description',
        'level',
        'created_at'
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
     * @var bool
     */
    public bool $isCreating = false;

    /**
     * Number of rows displayed on a page.
     * @var int
     */
    public int $perPage = 25;

    /**
     * Flash messages for the model.
     *
     * @var array
     */
    protected array $flashMessages = [
        'create' => [
            'success' => "Le role <b>:name</b> a été créé avec succès !",
            'error' => "Une erreur s'est produite lors de la création du rôle !"
        ],
        'update' => [
            'success' => "Le rôle <b>:name</b> a été édité avec succès !",
            'error' => "Une erreur s'est produite lors de l'édition du rôle !"
        ],
        'delete' => [
            'success' => "<b>:count</b> rôle(s) ont été supprimé(s) avec succès !",
            'error' => "Une erreur s'est produite lors de la suppression des rôles !"
        ]
    ];

    /**
     * Function to render the component.
     *
     * @return View
     */
    public function render(): View
    {
        // Select all permissions except `bypass login` who is assigned to the `site_id` 0.
        $permissions = Permission::where('name', '<>', 'bypass login')->select(['id', 'name', 'description'])
            ->orderBy('name')
            ->get()
            ->toArray();

        return view('livewire.roles.roles', [
            'roles' => $this->rows,
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
        $query = Role::where(function($query) {
            return $query->whereNull(PermissionRegistrar::$teamsKey)
                ->orWhere(PermissionRegistrar::$teamsKey, getPermissionsTeamId());
        });

        if (Auth::user()->can('search', Role::class)) {
            $query->when($this->filters['name'], fn($query, $search) => $query->where('name', 'LIKE', '%' . $search . '%'))
                ->when($this->filters['description'], fn($query, $search) => $query->where('description', 'LIKE', '%' . $search . '%'))
                ->when($this->filters['level_min'], fn($query, $search) => $query->where('level', '>=', $search))
                ->when($this->filters['level_max'], fn($query, $search) => $query->where('level', '<=', $search))
                ->when($this->filters['created_min'], fn($query, $date) => $query->where('created_at', '>=', Carbon::parse($date)))
                ->when($this->filters['created_max'], fn($query, $date) => $query->where('created_at', '<=', Carbon::parse($date)));
        }

        //dd($query->dd());

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
        $this->authorize('create', Role::class);

        $this->isCreating = true;
        $this->useCachedRows();

        $this->form->reset();

        $this->showModal = true;
    }

    /**
     * Set the model (used in modal) to the role we want to edit.
     *
     * @param Role $role The role id to update.
     * (Livewire will automatically fetch the model by the id)
     *
     * @return void
     */
    public function edit(Role $role): void
    {
        $this->authorize('update', $role);

        $this->isCreating = false;
        $this->useCachedRows();

        $this->form->setRole($role);

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
            $this->authorize('create', Role::class) :
            $this->authorize('update', $this->form->role);

        $this->validate();

        $model = $this->isCreating ? $this->form->store() : $this->form->update();

        $this->success($this->flashMessages[$this->isCreating ? 'create' : 'update']['success'], ['name' => $model->name]);

        $this->showModal = false;
    }
}
