<?php

namespace BDS\Livewire\Roles;

use BDS\Livewire\Forms\RoleForm;
use BDS\Livewire\Traits\WithBulkActions;
use BDS\Livewire\Traits\WithCachedRows;
use BDS\Livewire\Traits\WithFilters;
use BDS\Livewire\Traits\WithFlash;
use BDS\Livewire\Traits\WithPerPagePagination;
use BDS\Livewire\Traits\WithSorting;
use BDS\Models\User;
use Carbon\Carbon;
use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class Roles extends Component
{
    use AuthorizesRequests;
    use WithBulkActions;
    use WithCachedRows;
    use WithFilters;
    use WithFlash;
    use WithPagination;
    use WithPerPagePagination;
    use WithSorting;

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
    public string $sortField = 'name';

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
     * Translated attribute used in failed messages.
     *
     * @var array
     */
    protected array $validationAttributes = [
        'form.name' => 'nom',
        'form.description' => 'description',
        'form.color' => 'couleur',
        'form.permissions' => 'permissions'
    ];

    /**
     * Flash messages for the model.
     *
     * @var array
     */
    protected array $flashMessages = [
        'create' => [
            'success' => "Le role <b>%s</b> a été créé avec succès !",
            'danger' => "Une erreur s'est produite lors de la création du rôle !"
        ],
        'update' => [
            'success' => "Le rôle <b>%s</b> a été édité avec succès !",
            'danger' => "Une erreur s'est produite lors de l'édition du rôle !"
        ],
        'delete' => [
            'success' => "<b>%s</b> rôle(s) ont été supprimé(s) avec succès !",
            'danger' => "Une erreur s'est produite lors de la suppression des rôles !"
        ]
    ];


    /**
     * The Livewire Component constructor.
     *
     * @return void
     */
    public function mount(): void
    {
        $this->applySortingOnMount();

        $this->applyFilteringOnMount();
    }

    /**
     * Rules used for validating the model.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'form.name' => 'required|min:2|max:50|unique:roles,name,' . $this->form->role?->id,
            'form.description' => 'max:350',
            'form.color' => 'min:7|max:9',
            'form.permissions' => 'required'
        ];
    }

    /**
     * Function to render the component.
     *
     * @return View
     */
    public function render(): View
    {
        return view('livewire.roles.roles', [
            'roles' => $this->rows,
            'permissions' => Permission::query()->select(['id', 'name'])->orderBy('name')->get()->toArray(),
        ]);
    }

    /**
     * Create and return the query for the items.
     *
     * @return Builder
     */
    public function getRowsQueryProperty(): Builder
    {
        $query = Role::query();

        if (Auth::user()->can('search', Role::class)) {
            $query->when($this->filters['name'], fn($query, $search) => $query->where('name', 'LIKE', '%' . $search . '%'))
                ->when($this->filters['description'], fn($query, $search) => $query->where('description', 'LIKE', '%' . $search . '%'))
                ->when($this->filters['created_min'], fn($query, $date) => $query->where('created_at', '>=', Carbon::parse($date)))
                ->when($this->filters['created_max'], fn($query, $date) => $query->where('created_at', '<=', Carbon::parse($date)));
        }

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
        $this->authorize('update', Role::class);

        $this->isCreating = false;
        $this->useCachedRows();

        // Set the model to the role we want to edit and set the related permissions.
        $permissions = $role->permissions()->pluck('id')->toArray();

        $this->form->setRole($role, $permissions);

        $this->showModal = true;
    }

    /**
     * Validate and save the model.
     *
     * @return void
     */
    public function save(): void
    {
        $this->authorize($this->isCreating ? 'create' : 'update', Role::class);

        $this->validate();

        $model = $this->isCreating ? $this->form->store() : $this->form->update();

        if ($model) {
            $this->fireFlash($this->isCreating ? 'create' : 'update', 'success', '', [$model->name]);
        } else {
            $this->fireFlash($this->isCreating ? 'create' : 'update', 'danger');
        }
        $this->showModal = false;
    }
}
