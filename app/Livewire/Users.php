<?php

namespace BDS\Livewire;

use BDS\Events\Auth\RegisteredEvent;
use BDS\Livewire\Traits\WithBulkActions;
use BDS\Livewire\Traits\WithCachedRows;
use BDS\Livewire\Traits\WithFlash;
use BDS\Livewire\Traits\WithPerPagePagination;
use BDS\Livewire\Traits\WithSorting;
use BDS\Models\User;
use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Pagination\LengthAwarePaginator;
use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Permission\Models\Role;

class Users extends Component
{
    use AuthorizesRequests;
    use WithBulkActions;
    use WithCachedRows;
    use WithFlash;
    use WithPagination;
    use WithPerPagePagination;
    use WithSorting;

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
     * The string to search.
     *
     * @var string
     */
    public string $search = '';

    /**
     * Used to update in URL the query string.
     *
     * @var string[]
     */
    protected array $queryString = [
        'sortField' => ['as' => 'f'],
        'sortDirection' => ['as' => 'd'],
        'search' => ['as' => 's']
    ];

    /**
     * Array of allowed fields.
     *
     * @var array
     */
    public array $allowedFields = [
        'id',
        'username',
        /*'first_name',
        'last_name',*/
        'email',
        'last_login',
        'created_at'
    ];

    /**
     * The model used in the component.
     *
     * @var User
     */
    public User $model;

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
    public int $perPage = 15;

    /**
     * The selected roles for the editing an user or the new user.
     *
     * @var array
     */
    public array $rolesSelected = [];

    /**
     * Translated attribute used in failed messages.
     *
     * @var string[]
     */
    protected array $validationAttributes = [
        'username' => 'nom d\'utilisateur',
        'first_name' => 'prénom',
        'last_name' => 'nom',
        'rolesSelected' => 'rôles'
    ];

    /**
     * Flash messages for the model.
     *
     * @var array
     */
    protected array $flashMessages = [
        'create' => [
            'success' => "L'utilisateur <b>%s</b> a été créé avec succès !",
            'danger' => "Une erreur s'est produite lors de la création de l'utilisateur !"
        ],
        'update' => [
            'success' => "L'utilisateur <b>%s</b> a été édité avec succès !",
            'danger' => "Une erreur s'est produite lors de l'édition de l'utilisateur !"
        ],
        'delete' => [
            'success' => "<b>%s</b> utilisateur(s) ont été supprimé(s) avec succès !",
            'danger' => "Une erreur s'est produite lors de la suppression des utilisateurs !"
        ],
        'restore' => [
            'success' => "L'utilisateur <b>%s</b> a été restauré avec succès !",
            'danger' => "Une erreur s'est produite lors de la restauration de l'utilisateur !"
        ]
    ];

    /**
     * The Livewire Component constructor.
     *
     * @return void
     */
    public function mount(): void
    {
        $this->model = $this->makeBlankModel();

        $this->applySortingOnMount();
    }

    /**
     * Rules used for validating the model.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'model.username' => 'required|regex:/^[\w.]*$/|min:5|max:30|unique:users,username,' . $this->model->id,
            'model.email' => 'required|email|unique:users,email,' . $this->model->id,
            /*'model.first_name' => 'required',
            'model.last_name' => 'required',*/
            'rolesSelected' => 'required'
        ];
    }

    /**
     * Create a blank model and return it.
     *
     * @return User
     */
    public function makeBlankModel(): User
    {
        return User::make();
    }

    /**
     * Function to render the component.
     *
     * @return View
     */
    public function render(): View
    {
        return view('livewire.users', [
            'users' => $this->rows,
            'roles' => Role::pluck('name', 'id')->toArray()
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
            ->withCount('roles')
            ->orderByDesc('roles_count')
            //->with('roles')
            /*->orderBy('roles', function($query){

                return $query->roles()->count();

            })*/
            ->search('username', $this->search)
            ->withTrashed();

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

        // Reset the model to a blank model before showing the creating modal.
        if ($this->model->getKey()) {
            $this->model = $this->makeBlankModel();
            $this->rolesSelected = [];
        }
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
        $this->authorize('update', User::class);

        $this->isCreating = false;
        $this->useCachedRows();

        // Set the model to the user we want to edit.
        if ($this->model->isNot($user)) {
            $this->model = $user;
            $this->rolesSelected = $user->roles->pluck('id')->toArray();
        }
        $this->showModal = true;
    }

    /**
     * Validate and save the model.
     *
     * @return void
     */
    public function save(): void
    {
        $this->authorize($this->isCreating ? 'create' : 'update', User::class);

        $this->validate();

        if ($this->model->save()) {
            $this->model->syncRoles($this->rolesSelected);

            if ($this->isCreating === true) {
                event(new RegisteredEvent($this->model));
            }

            $this->fireFlash($this->isCreating ? 'create' : 'update', 'success', '', [$this->model->username]);
        } else {
            $this->fireFlash($this->isCreating ? 'create' : 'update', 'danger');
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

        if ($this->model->restore()) {
            $this->fireFlash('restore', 'success','', [$this->model->username]);
        } else {
            $this->fireFlash('restore', 'danger');
        }
    }
}
