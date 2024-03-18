<?php

namespace BDS\Livewire;

use BDS\Livewire\Forms\MaintenanceForm;
use BDS\Livewire\Traits\WithBulkActions;
use BDS\Livewire\Traits\WithCachedRows;
use BDS\Livewire\Traits\WithConvertEmptyStringsToNull;
use BDS\Livewire\Traits\WithFilters;
use BDS\Livewire\Traits\WithPerPagePagination;
use BDS\Livewire\Traits\WithRemoveRMFromArray;
use BDS\Livewire\Traits\WithSorting;
use BDS\Livewire\Traits\WithToast;
use BDS\Models\Company;
use BDS\Models\Incident;
use BDS\Models\Maintenance;
use BDS\Models\Material;
use BDS\Models\Part;
use BDS\Models\User;
use Carbon\Carbon;
use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;
use Livewire\WithPagination;

class Maintenances extends Component
{
    use AuthorizesRequests;
    use WithBulkActions;
    use WithCachedRows;
    use WithConvertEmptyStringsToNull;
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
    public string $model = Maintenance::class;

    /**
     * The form used to create/update a model.
     *
     * @var MaintenanceForm
     */
    public MaintenanceForm $form;

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
        'gmao' => '',
        'material' => '',
        'creator' => '',
        'description' => '',
        'reason' => '',
        'type' => '',
        'realization' => '',
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
        'gmao_id',
        'material_id',
        'description',
        'reason',
        'user_id',
        'type',
        'realization',
        'started_at',
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
            'success' => "La maintenance n°<b>:id</b> a été créée avec succès !",
            'danger' => "Une erreur s'est produite lors de la création de la maintenance !"
        ],
        'update' => [
            'success' => "La maintenance n°<b>:id</b> a été éditée avec succès !",
            'danger' => "Une erreur s'est produite lors de l'édition de la maintenance !"
        ],
        'delete' => [
            'success' => "<b>:count</b> maintenance(s) ont été supprimée(s) avec succès !",
            'danger' => "Une erreur s'est produite lors de la suppression de(s) maintenance(s) !"
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
                $this->authorize('create', Maintenance::class);

                $this->isCreating = true;
                $this->useCachedRows();

                $this->form->reset();
                $this->form->material_id = $material->id;

                $this->searchMaterial();
                $this->searchOperators();
                $this->searchCompanies();
                $this->searchIncidents();
                $this->searchPart();

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
        return view('livewire.maintenances', [
            'maintenances' => $this->rows
        ]);
    }

    public function updatedFormOperators($value, $name) {
        dd($value, $name);
    }

    /**
     * Create and return the query for the items.
     *
     * @return Builder
     */
    public function getRowsQueryProperty(): Builder
    {
        $query = Maintenance::query()
            ->with('material', 'user', 'site');

        if (getPermissionsTeamId() !== settings('site_id_verdun_siege')) {
            $query->where('site_id', getPermissionsTeamId());
        }

        if (Gate::allows('search', Maintenance::class)) {
            // This filter is only present on Verdun Siege site.
            if(getPermissionsTeamId() === settings('site_id_verdun_siege')){
                $query->when($this->filters['site'], function ($query, $search) {
                    return $query->whereHas('site', function ($partQuery) use ($search) {
                        $partQuery->where('name', 'LIKE', '%' . $search . '%');
                    });
                });
            }

            $query
                ->when($this->filters['id'], fn($query, $id) => $query->where('id', $id))
                ->when($this->filters['gmao'], fn($query, $id) => $query->where('gmao_id', $id))
                ->when($this->filters['material'], function ($query, $search) {
                    return $query->whereHas('material', function ($partQuery) use ($search) {
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
                ->when($this->filters['type'], function ($query, $search) {
                    if ($search !== 'Tous') {
                        return $query->where('type', $search);
                    }
                    return $query;
                })
                ->when($this->filters['realization'], function ($query, $search) {
                    if ($search !== 'Tous') {
                        return $query->where('realization', $search);
                    }
                    return $query;
                })
                ->when($this->filters['finished'], function ($query, $search) {
                    if ($search === 'yes') {
                        return $query->where('is_finished', true);
                    }
                    return $query->where('is_finished', false);
                })
                ->when($this->filters['started_min'], fn($query, $date) => $query->where('created_at', '>=', Carbon::parse($date)))
                ->when($this->filters['started_max'], fn($query, $date) => $query->where('created_at', '<=', Carbon::parse($date)))

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
     * Initialize search functions and reset form.
     *
     * @return void
     */
    public function create(): void
    {
        $this->authorize('create', Maintenance::class);

        $this->isCreating = true;
        $this->useCachedRows();

        $this->form->reset();

        $this->searchMaterial();
        $this->searchOperators();
        $this->searchCompanies();
        $this->searchIncidents();
        $this->searchPart();

        $this->showModal = true;
    }

    /**
     * Set the model (used in modal) to the maintenance we want to edit.
     *
     * @param Maintenance $maintenance The maintenance id to update.
     * (Livewire will automatically fetch the model by the id)
     *
     * @return void
     */
    public function edit(Maintenance $maintenance): void
    {
        $this->authorize('update', $maintenance);

        $this->isCreating = false;
        $this->useCachedRows();

        $this->form->setForm($maintenance);
        $this->searchMaterial();
        $this->searchOperators();
        $this->searchCompanies();
        $this->searchIncidents();

        $this->showModal = true;
    }

    /**
     * Validate and save the model.
     *
     * @return void
     */
    public function save(): void
    {
        $this->authorize($this->isCreating ? 'create' : 'update', Maintenance::class);

        $this->validate();

        $model = $this->isCreating ? $this->form->store() : $this->form->update();

        $this->success($this->flashMessages[$this->isCreating ? 'create' : 'update']['success'], ['id' => $model->getKey()]);

        $this->showModal = false;
    }

    /**
     * Function to remove a part from the create form.
     *
     * @param $key
     *
     * @return void
     */
    public function removePart($key): void
    {
        $this->form->parts->pull($key);
    }

    /**
     * Function to add a part to the create form.
     *
     * @return void
     */
    public function addPart(): void
    {
        if (empty($this->form->parts)) {
            $this->form->fill([
                'parts' => collect([['part_id' => '', 'number' => '']])
            ]);
        } else {
            $this->form->parts->push(['part_id' => '', 'number' => '']);
        }

    }

    /**
     * Function to search operators in form.
     *
     * @param string $value
     *
     * @return void
     */
    public function searchOperators(string $value = ''): void
    {
        // Besides the search results, you must include on demand selected option
        if (!empty($this->form->operators)) {
            $selectedOption = User::whereIn('id', $this->form->operators)->get();
        } else {
            $selectedOption = [];
        }

        $operators = User::query()
            ->with(['roles', 'sites'])
            ->whereRelation('sites', 'site_id', getPermissionsTeamId())
            ->where(function($query) use ($value) {
                return $query->where('first_name', 'like', "%$value%")
                    ->orWhere('last_name', 'like', "%$value%");
            });

        $operators = $operators->take(10)
            ->orderBy('first_name')
            ->get()
            ->merge($selectedOption);

        $this->form->operatorsSearchable = $operators;
    }

    /**
     * Function to search companies in form.
     *
     * @param string $value
     *
     * @return void
     */
    public function searchCompanies(string $value = ''): void
    {
        // Besides the search results, you must include on demand selected option
        if (!empty($this->form->companies)) {
            $selectedOption = Company::whereIn('id', $this->form->companies)->get();
        } else {
            $selectedOption = [];
        }

        $companies = Company::where('site_id', getPermissionsTeamId())
            ->where('name', 'like', "%$value%");

        $companies = $companies->take(10)
            ->orderBy('name')
            ->get()
            ->merge($selectedOption);

        $this->form->companiesSearchable = $companies;
    }

    /**
     * Function to search incidents in form.
     *
     * @param string $value
     *
     * @return void
     */
    public function searchIncidents(string $value = ''): void
    {
        // Besides the search results, you must include on demand selected option
        if (!empty($this->form->incidents)) {
            $selectedOption = Incident::whereIn('id', $this->form->incidents)->get();
        } else {
            $selectedOption = [];
        }

        $incidents = Incident::query()
            ->whereRelation('material.zone', 'site_id', getPermissionsTeamId())
            ->where(function ($partQuery) use ($value) {
                $partQuery
                    ->where('id', 'like', "%$value%")
                    ->orWhereHas('material', function ($partQuery) use ($value) {
                        $partQuery->where('name', 'like', "%$value%");
                    });
            });
        //dd($incidents->toSql());
        $incidents = $incidents->take(10)
            ->orderBy('id', 'desc')
            ->get()
            ->merge($selectedOption);

        $this->form->incidentsSearchable = $incidents;
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
            ->whereRelation('zone.site', 'id', getPermissionsTeamId())
            ->where('name', 'like', "%$value%");

        $materials = $materials->take(10)
            ->orderBy('name')
            ->get()
            ->merge($selectedOption);

        $this->form->materialsSearchable = $materials;
    }

    /**
     * Function to search parts in form.
     *
     * @param string $value
     *
     * @return void
     */
    public function searchPart(string $value = ''): void
    {
        // Besides the search results, you must include on demand selected option
        if (!empty($this->form->parts)) {
            $selectedOption = Part::whereIn('id', collect($this->form->parts)->map(function ($item) {
                return $item['part_id'];
            })->sort()->values())->get();
        } else {
            $selectedOption = [];
        }

        $parts = Part::query()
            ->with(['site'])
            ->where('name', 'like', "%$value%")
            ->where('site_id', getPermissionsTeamId());

        $parts = $parts->take(10)
            ->orderBy('name')
            ->get()
            ->merge($selectedOption);

        $this->form->partsSearchable = $parts;
    }
}
