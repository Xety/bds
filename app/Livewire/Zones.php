<?php

namespace BDS\Livewire;

use BDS\Livewire\Traits\WithBulkActions;
use BDS\Livewire\Traits\WithCachedRows;
use BDS\Livewire\Traits\WithFlash;
use BDS\Livewire\Traits\WithPerPagePagination;
use BDS\Livewire\Traits\WithSorting;
use BDS\Models\Zone;
use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class Zones extends Component
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
    public string $sortDirection = 'desc';

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
    protected $queryString = [
        'sortField' => ['as' => 'f'],
        'sortDirection' => ['as' => 'd'],
        'search' => ['except' => '', 'as' => 's']
    ];

    /**
     * Array of allowed fields.
     *
     * @var array
     */
    public array $allowedFields = [
        'id',
        'name',
        'material_count',
        'created_at'
    ];

    /**
     * The model used in the component.
     *
     * @var Zone
     */
    public Zone $model;

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
            'success' => "La zone <b>%s</b> a été créée avec succès !",
            'danger' => "Une erreur s'est produite lors de la création de la zone !"
        ],
        'update' => [
            'success' => "La zone <b>%s</b> a été éditée avec succès !",
            'danger' => "Une erreur s'est produite lors de l'édition de la zone !"
        ],
        'delete' => [
            'success' => "<b>%s</b> zone(s) ont été supprimée(s) avec succès !",
            'danger' => "Une erreur s'est produite lors de la suppression des zones !"
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
            'model.name' => 'required|min:2|max:150|unique:zones,name,' . $this->model->id
        ];
    }

    /**
     * Create a blank model and return it.
     *
     * @return Zone
     */
    public function makeBlankModel(): Zone
    {
        return Zone::make();
    }

    /**
     * Function to render the component.
     *
     * @return View
     */
    public function render(): View
    {
        return view('livewire.zones', [
            'zones' => $this->rows
        ]);
    }

    /**
     * Create and return the query for the items.
     *
     * @return Builder
     */
    public function getRowsQueryProperty(): Builder
    {
        $query = Zone::query()
            ->with('materials')
            /*->withCount(['materials as incidentsCount' => function ($query) {
                $query->select(DB::raw('SUM(incident_count)'));
            }])
            ->withCount(['materials as maintenancesCount' => function ($query) {
                $query->select(DB::raw('SUM(maintenance_count)'));
            }])*/
            ->search('name', $this->search);

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
        $this->authorize('create', Zone::class);

        $this->isCreating = true;
        $this->useCachedRows();

        // Reset the model to a blank model before showing the creating modal.
        if ($this->model->getKey()) {
            $this->model = $this->makeBlankModel();
        }
        $this->showModal = true;
    }

    /**
     * Set the model (used in modal) to the zone we want to edit.
     *
     * @param Zone $zone The zone id to update.
     * (Livewire will automatically fetch the model by the id)
     *
     * @return void
     */
    public function edit(Zone $zone): void
    {
        $this->authorize('update', Zone::class);

        $this->isCreating = false;
        $this->useCachedRows();

        // Set the model to the zone we want to edit.
        if ($this->model->isNot($zone)) {
            $this->model = $zone;
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
        $this->authorize($this->isCreating ? 'create' : 'update', Zone::class);

        $this->validate();

        if ($this->model->save()) {
            $this->fireFlash($this->isCreating ? 'create' : 'update', 'success','', [$this->model->name]);
        } else {
            $this->fireFlash($this->isCreating ? 'create' : 'update', 'danger');
        }
        $this->showModal = false;
    }
}
