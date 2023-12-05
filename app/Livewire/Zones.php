<?php

namespace BDS\Livewire;

use BDS\Livewire\Forms\ZoneForm;
use BDS\Livewire\Traits\WithBulkActions;
use BDS\Livewire\Traits\WithCachedRows;
use BDS\Livewire\Traits\WithPerPagePagination;
use BDS\Livewire\Traits\WithSorting;
use BDS\Livewire\Traits\WithToast;
use BDS\Models\Zone;
use Carbon\Carbon;
use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithPagination;

class Zones extends Component
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
    public string $model = Zone::class;

    /**
     * The form used to create/update a user.
     *
     * @var ZoneForm
     */
    public ZoneForm $form;

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
     * Used to update in URL the query string.
     *
     * @var string[]
     */
    protected $queryString = [
        'sortField' => ['as' => 'f'],
        'sortDirection' => ['as' => 'd'],
        'editing',
        'zoneId',
        'creating',
        'zoneSubId',
        'filters',
    ];

    /**
     * Filters used for advanced search.
     *
     * @var array
     */
    public array $filters = [
        'name' => '',
        'parent' => '',
        'allow_material' => '',
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
        'parent_id',
        'material_count',
        'created_at'
    ];

    /**
     * Whatever the Editing url param is set or not.
     *
     * @var bool
     */
    public bool|string $editing = '';

    /**
     * The zone id if set.
     *
     * @var null|int
     */
    public null|int $zoneId = null;

    /**
     * Whatever the Editing url param is set or not.
     *
     * @var bool
     */
    public bool|string $creating = '';

    /**
     * The zone sub id if set.
     *
     * @var null|int
     */
    public null|int $zoneSubId = null;

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
            'success' => "La zone <b>:name</b> a été créée avec succès !",
            'danger' => "Une erreur s'est produite lors de la création de la zone !"
        ],
        'update' => [
            'success' => "La zone <b>:name</b> a été éditée avec succès !",
            'danger' => "Une erreur s'est produite lors de l'édition de la zone !"
        ],
        'delete' => [
            'success' => "<b>:count</b> zone(s) ont été supprimée(s) avec succès !",
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
        // Check if the edit option is set into the url, and if yes, open the Edit Modal (if the user has the permissions).
        if ($this->editing === true && $this->zoneId !== null) {
            $zone = Zone::whereId($this->zoneId)->first();

            if ($zone) {
                $this->edit($zone);
            }
        }

        // Check if the create option is set into the url, and if yes, open the Create Modal (if the user has the permissions).
        if ($this->creating === true && $this->zoneSubId !== null) {
            // Must check the site_id of the sub, to be sure the user does not try to use a zone from another site.
            $zone = Zone::whereId($this->zoneSubId)->where('site_id', getPermissionsTeamId())->first();

            if ($zone) {
                $this->create();

                $this->form->parent_id = $zone->id;
            }
        }
    }

    /**
     * Function to render the component.
     *
     * @return View
     */
    public function render(): View
    {
        return view('livewire.zones', [
            'zones' => $this->rows,
            'zonesList' => Zone::where('site_id', session('current_site_id'))
                ->where('id', '!=', $this->form->zone?->id)
                ->orderBy('name')
                ->get()
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
            ->with('site', 'materials', 'parent')
            ->whereRelation('site', 'id', session('current_site_id'));
            /*->withCount(['materials as incidentsCount' => function ($query) {
                $query->select(DB::raw('SUM(incident_count)'));
            }])
            ->withCount(['materials as maintenancesCount' => function ($query) {
                $query->select(DB::raw('SUM(maintenance_count)'));
            }])*/
            //->search('name', $this->search);
        if (Auth::user()->can('search', Zone::class)) {
            $query->when($this->filters['name'], fn($query, $search) => $query->where('name', 'LIKE', '%' . $search . '%'))
                ->when($this->filters['parent'], function ($query, $search) {
                    return $query->whereHas('parent', function ($partQuery) use ($search) {
                        $partQuery->where('name', 'LIKE', '%' . $search . '%');
                    });
                })
                ->when($this->filters['allow_material'], function ($query, $search) {
                    if ($search === 'yes') {
                        return $query->where('allow_material', true);
                    }
                    return $query->where('allow_material', false);
                })
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
        $this->authorize('create', Zone::class);

        $this->isCreating = true;
        $this->useCachedRows();

        $this->form->reset();

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
        $this->authorize('update', $zone);

        $this->isCreating = false;
        $this->useCachedRows();

        $this->form->setZone($zone);

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

        // Must change the 0 value from "Aucun Parent" to null before validating.
        $this->form->parent_id = $this->form->parent_id === 0 ? null : $this->form->parent_id;

        $this->validate();

        $model = $this->isCreating ? $this->form->store() : $this->form->update();

        $this->success($this->flashMessages[$this->isCreating ? 'create' : 'update']['success'], ['name' => $model->name]);

        $this->showModal = false;
    }
}
