<?php

namespace BDS\Livewire;

use BDS\Livewire\Forms\SiteForm;
use BDS\Livewire\Traits\WithBulkActions;
use BDS\Livewire\Traits\WithCachedRows;
use BDS\Livewire\Traits\WithPerPagePagination;
use BDS\Livewire\Traits\WithSorting;
use BDS\Livewire\Traits\WithToast;
use BDS\Models\Site;
use BDS\Models\User;
use Carbon\Carbon;
use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class Sites extends Component
{
    use AuthorizesRequests;
    use WithBulkActions;
    use WithCachedRows;
    use WithPagination;
    use WithPerPagePagination;
    use WithSorting;
    use WithToast;

    /**
     * Bind the main model used in the component to be used in traits.
     *
     * @var string
     */
    public string $model = Site::class;

    /**
     * The form used to create/update a user.
     *
     * @var SiteForm
     */
    public SiteForm $form;

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
     * Used to update in URL the query string.
     *
     * @var string[]
     */
    protected $queryString = [
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
        'id',
        'name' => '',
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
        'zone_count',
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
            'success' => "Le site <b>:name</b> a été créé avec succès !",
            'danger' => "Une erreur s'est produite lors de la création du site !"
        ],
        'update' => [
            'success' => "Le site <b>:name</b> a été édité avec succès !",
            'danger' => "Une erreur s'est produite lors de l'édition du site !"
        ],
        'delete' => [
            'success' => "<b>:count</b> site(s) ont été supprimé(s) avec succès !",
            'danger' => "Une erreur s'est produite lors de la suppression des sites !"
        ]
    ];

    /**
     * Function to render the component.
     *
     * @return View
     */
    public function render(): View
    {
        return view('livewire.sites', [
            'sites' => $this->rows,
            'users' => User::whereRelation('sites', 'site_id', $this->form->site?->id)
                ->select(['id', DB::raw('CONCAT(first_name, " ", last_name) AS name')])
                ->get()
                ->toArray()
        ]);
    }

    /**
     * Create and return the query for the items.
     *
     * @return Builder
     */
    public function getRowsQueryProperty(): Builder
    {
        $query = Site::query()
        ->with('managers');

        if (Auth::user()->can('search', Site::class)) {
            $query->when($this->filters['name'], fn($query, $search) => $query->where('name', 'LIKE', '%' . $search . '%'))
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
        $this->authorize('create', Site::class);

        $this->isCreating = true;
        $this->useCachedRows();

        $this->form->reset();

        $this->showModal = true;
    }

    /**
     * Set the model (used in modal) to the zone we want to edit.
     *
     * @param Site $site The site id to update.
     * (Livewire will automatically fetch the model by the id)
     *
     * @return void
     */
    public function edit(Site $site): void
    {
        $this->authorize('update', $site);

        $this->isCreating = false;
        $this->useCachedRows();

        $managers = $site->managers()->pluck('id')->toArray();

        $this->form->setSite($site, $managers);

        $this->showModal = true;
    }

    /**
     * Validate and save the model.
     *
     * @return void
     */
    public function save(): void
    {
        $this->authorize($this->isCreating ? 'create' : 'update', Site::class);

        $this->validate();

        $model = $this->isCreating ? $this->form->store() : $this->form->update();

        $this->success($this->flashMessages[$this->isCreating ? 'create' : 'update']['success'], ['name' => $model->name]);

        $this->showModal = false;
    }
}
