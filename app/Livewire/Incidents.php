<?php

namespace BDS\Livewire;

use BDS\Livewire\Forms\IncidentForm;
use BDS\Livewire\Traits\WithBulkActions;
use BDS\Livewire\Traits\WithCachedRows;
use BDS\Livewire\Traits\WithFilters;
use BDS\Livewire\Traits\WithPerPagePagination;
use BDS\Livewire\Traits\WithSorting;
use BDS\Livewire\Traits\WithToast;
use BDS\Models\Incident;
use BDS\Models\Maintenance;
use BDS\Models\Material;
use Carbon\Carbon;
use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;
use Livewire\WithPagination;

class Incidents extends Component
{
    use AuthorizesRequests;
    use WithBulkActions;
    use WithCachedRows;
    use WithFilters;
    use WithPagination;
    use WithPerPagePagination;
    use WithSorting;
    use WithToast;

    /**
     * Bind the main model used in the component to be used in traits.
     *
     * @var string
     */
    public string $model = Incident::class;

    /**
     * The form used to create/update a cleaning.
     *
     * @var IncidentForm
     */
    public IncidentForm $form;

    /**
     * The field to sort by.
     *
     * @var string
     */
    public string $sortField = 'id';

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
    protected array $queryString = [
        'sortField' => ['as' => 'f'],
        'sortDirection' => ['as' => 'd'],
        'creating',
        'materialId',
        'filters',
    ];

    /**
     * Whatever the QR Code is set or not.
     *
     * @var bool
     */
    public bool $creating = false;

    /**
     * The QR Code id if set.
     *
     * @var int|null
     */
    public ?int $materialId = null;

    /**
     * Filters used for advanced search.
     *
     * @var array
     */
    public array $filters = [
        'id' => '',
        'site' => '',
        'maintenance' => '',
        'material' => '',
        'zone' => '',
        'creator' => '',
        'description' => '',
        'impact' => '',
        'finished' => '',
        'started_min' => '',
        'started_max' => '',
        'finished_min' => '',
        'finished_max' => '',
    ];

    /**
     * Array of allowed fields.
     *
     * @var array
     */
    public array $allowedFields = [
        'id',
        'site_id',
        'material_id',
        'user_id',
        'description',
        'started_at',
        'impact',
        'is_finished',
        'finished_at'
    ];

    /**
     * Flash messages for the model.
     *
     * @var array
     */
    protected array $flashMessages = [
        'create' => [
            'success' => "L'incident n°<b>:id</b> a été créé avec succès !",
            'danger' => "Une erreur s'est produite lors de la création de l'incident !"
        ],
        'update' => [
            'success' => "L'incident n°<b>:id</b> a été édité avec succès !",
            'danger' => "Une erreur s'est produite lors de l'édition de l'incident !"
        ],
        'delete' => [
            'success' => "<b>:count</b> incident(s) ont été supprimé(s) avec succès !",
            'danger' => "Une erreur s'est produite lors de la suppression de(s) incident(s) !"
        ]
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
     *
     * @var int
     */
    public int $perPage = 25;

    /**
     * The Livewire Component constructor.
     *
     * @return void
     */
    public function mount(): void
    {
        // Check if the creating option is set into the url, and if yes, open the Create Modal (if the user has the permissions).
        if ($this->creating === true && $this->materialId !== null) {
            // Must check the site_id of the zone that belong to the material,
            // to be sure the user does not try to use a material from another site.
            $material = Material::whereId($this->materialId)
                ->whereRelation('zone.site', 'id', getPermissionsTeamId())
                ->first();

            if ($material) {
                $this->authorize('create', Incident::class);

                $this->isCreating = true;
                $this->useCachedRows();

                $this->form->reset();
                $this->form->material_id = $material->id;

                $this->searchMaintenance();
                $this->searchMaterial();

                $this->showModal = true;
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
        return view('livewire.incidents', [
            'incidents' => $this->rows
        ]);
    }

    /**
     * Create and return the query for the items.
     *
     * @return Builder
     */
    public function getRowsQueryProperty(): Builder
    {
        $query = Incident::query()
            ->with('material', 'user', 'site');

        if (getPermissionsTeamId() !== settings('site_id_verdun_siege')) {
            $query->where('site_id', getPermissionsTeamId());
        }

        if (Gate::allows('search', Incident::class)) {
            // This filter is only present on Verdun Siege site.
            if(getPermissionsTeamId() === settings('site_id_verdun_siege')){
                $query->when($this->filters['site'], function ($query, $search) {
                    return $query->whereHas('site', function ($partQuery) use ($search) {
                        $partQuery->where('name', 'LIKE', '%' . $search . '%');
                    });
                });
            }

            $query->when($this->filters['id'], fn($query, $id) => $query->where('id', $id))
                ->when($this->filters['maintenance'], function ($query, $search) {
                    return $query->whereHas('maintenance', function ($partQuery) use ($search) {
                        $partQuery->where('id', 'LIKE', '%' . $search . '%');
                    });
                })
                ->when($this->filters['material'], function ($query, $search) {
                    return $query->whereHas('material', function ($partQuery) use ($search) {
                        $partQuery->where('name', 'LIKE', '%' . $search . '%');
                    });
                })
                ->when($this->filters['zone'], function ($query, $search) {
                    return $query->whereHas('material.zone', function ($partQuery) use ($search) {
                        $partQuery->where('name', 'LIKE', '%' . $search . '%');
                    });
                })
                ->when($this->filters['creator'], function ($query, $search) {
                    return $query->whereHas('user', function ($partQuery) use ($search) {
                        $partQuery->where('first_name', 'LIKE', '%' . $search . '%')
                            ->orWhere('last_name', 'LIKE', '%' . $search . '%');
                    });
                })
                ->when($this->filters['description'], fn($query, $search) => $query->where('description', 'LIKE', '%' . $search . '%'))
                ->when($this->filters['started_min'], fn($query, $date) => $query->where('created_at', '>=', Carbon::parse($date)))
                ->when($this->filters['started_max'], fn($query, $date) => $query->where('created_at', '<=', Carbon::parse($date)))
                ->when($this->filters['impact'], function ($query, $search) {
                    if ($search !== 'Tous') {
                        return $query->where('impact', $search);
                    }
                    return $query;
                })
                ->when($this->filters['finished'], function ($query, $search) {
                    if ($search === 'yes') {
                        return $query->where('is_finished', true);
                    }
                    return $query->where('is_finished', false);
                })
                ->when($this->filters['finished_min'], fn($query, $date) => $query->where('created_at', '>=', Carbon::parse($date)))
                ->when($this->filters['finished_max'], fn($query, $date) => $query->where('created_at', '<=', Carbon::parse($date)));
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
        $this->authorize('create', Incident::class);

        $this->isCreating = true;
        $this->useCachedRows();

        $this->form->reset();
        $this->searchMaintenance();
        $this->searchMaterial();

        $this->showModal = true;
    }

    /**
     * Set the model (used in modal) to the incident we want to edit.
     *
     * @param Incident $incident The incident id to update.
     * (Livewire will automatically fetch the model by the id)
     *
     * @return void
     */
    public function edit(Incident $incident): void
    {
        $this->authorize('update', $incident);

        $this->isCreating = false;
        $this->useCachedRows();

        $this->form->setForm($incident);
        $this->searchMaintenance();
        $this->searchMaterial();

        $this->showModal = true;
    }

    /**
     * Validate and save the model.
     *
     * @return void
     */
    public function save(): void
    {
        $this->authorize($this->isCreating ? 'create' : 'update', Incident::class);

        $this->validate();

        $model = $this->isCreating ? $this->form->store() : $this->form->update();

        $this->success($this->flashMessages[$this->isCreating ? 'create' : 'update']['success'], ['id' => $model->getKey()]);

        $this->showModal = false;
    }

    /**
     * Function to search maintenances in form.
     *
     * @param string $value
     *
     * @return void
     */
    public function searchMaintenance(string $value = ''): void
    {
        $selectedOption = Maintenance::where('id', $this->form->maintenance_id)->get();

        $maintenances = Maintenance::query()
            ->with(['material', 'material.zone.site'])
            ->where('id', 'like', "%$value%")
            ->whereRelation('material.zone.site', 'id', getPermissionsTeamId());

        $maintenances = $maintenances->take(10)
            ->orderBy('id')
            ->get()
            ->merge($selectedOption);

        $this->form->maintenancesSearchable = $maintenances;
    }

    /**
     * Function to search materials in form.
     *
     * @param string $value
     *
     * @return void
     */
    public function searchMaterial(string $value = ''): void
    {
        $selectedOption = Material::where('id', $this->form->material_id)->get();

        $materials = Material::query()
            ->with(['zone', 'zone.site'])
            ->where('name', 'like', "%$value%")
            ->whereRelation('zone.site', 'id', getPermissionsTeamId());

        $materials = $materials->take(10)
            ->orderBy('name')
            ->get()
            ->merge($selectedOption);

        $this->form->materialsSearchable = $materials;
    }
}
