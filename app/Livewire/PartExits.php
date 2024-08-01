<?php

namespace BDS\Livewire;

use BDS\Exports\PartExitsExport;
use BDS\Livewire\Forms\PartExitForm;
use BDS\Livewire\Traits\WithCachedRows;
use BDS\Livewire\Traits\WithSorting;
use BDS\Livewire\Traits\WithBulkActions;
use BDS\Livewire\Traits\WithPerPagePagination;
use BDS\Livewire\Traits\WithFilters;
use BDS\Livewire\Traits\WithToast;
use BDS\Models\Maintenance;
use BDS\Models\Part;
use BDS\Models\PartExit;
use BDS\Models\Site;
use Carbon\Carbon;
use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class PartExits extends Component
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
    public string $model = PartExit::class;

    /**
     * The form used to create/update a part exit.
     *
     * @var PartExitForm
     */
    public PartExitForm $form;

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
        'creating',
        'partId',
        'filters',
    ];

    /**
     * Filters used for advanced search.
     *
     * @var array
     */
    public array $filters = [
        'maintenance' => '',
        'part' => '',
        'site' => '',
        'user' => '',
        'description' => '',
        'number_min' => '',
        'number_max' => '',
        'created_min' => '',
        'created_max' => '',
    ];

    /**
     * Whatever the creating url param is set or not.
     *
     * @var bool
     */
    public bool|string $creating = '';

    /**
     * The part entry id if set.
     *
     * @var null|int
     */
    public null|int $partId = null;

    /**
     * Whatever the partId is verified.
     *
     * @var false
     */
    public bool $isPartVerified = false;

    /**
     * Array of allowed fields.
     *
     * @var array
     */
    public array $allowedFields = [
        'maintenance_id',
        'part_id',
        'description',
        'number',
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
     * Whatever the option to view part entries from other site is enabled/disabled.
     *
     * @var bool
     */
    public bool $viewOtherSitePartExit = false;

    /**
     * Flash messages for the model.
     *
     * @var array
     */
    protected array $flashMessages = [
        'create' => [
            'success' => "La sortie pour la pièce <b>:name</b> a été créé avec succès !",
            'danger' => "Une erreur s'est produite lors de la création de la sortie."
        ],
        'update' => [
            'success' => "La sortie pour la pièce <b>:name</b> a été édité avec succès !",
            'danger' => "Une erreur s'est produite lors de l'édition de la sortie."
        ],
        'delete' => [
            'success' => "<b>:count</b> sortie(s) ont été supprimée(s) avec succès !",
            'danger' => "Une erreur s'est produite lors de la suppression des sorties !"
        ]
    ];

    /**
     * The Livewire Component constructor.
     *
     * @return void
     */
    public function mount(): void
    {
        // Set the view other site part to true by default for maintenance site only.
        if (Gate::allows('viewOtherSite', PartExit::class) && getPermissionsTeamId() === settings('site_id_verdun_siege')) {
            $this->viewOtherSitePartExit = true;
        }

        // Check if the create option is set into the url, and if yes, open the Create Modal (if the user has the permissions).
        if ($this->creating === true && $this->partId !== null) {
            // Must check the site_id of the part, to be sure the user does not try to use a part from another site.
            $part = Part::whereId($this->partId)
                ->where('site_id', getPermissionsTeamId())
                ->first();

            if ($part) {
                $this->isPartVerified = true;

                $this->create();
            } else {
                $this->isPartVerified = false;
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
        return view('livewire.part-exits', [
            'partExits' => $this->rows
        ]);
    }

    /**
     * Create and return the query for the items.
     *
     * @return Builder
     */
    public function getRowsQueryProperty(): Builder
    {
        $query = PartExit::query()
            ->with('part', 'user');

        // If the user does not have the permissions to see parts exits from others sites
        // add a where condition to display only the part exits from the current site.
        if (!Gate::allows('viewOtherSite', PartExit::class) || !$this->viewOtherSitePartExit) {
            $query->whereHas('part', function ($partQuery) {
                $partQuery->where('site_id', getPermissionsTeamId());
            });
        }

        if (Gate::allows('search', PartExit::class)) {
            $query
                ->when($this->filters['maintenance'], function ($query, $search) {
                    return $query->whereHas('maintenance', function ($partQuery) use ($search) {
                        $partQuery->where('id', 'LIKE', '%' . $search . '%');
                    });
                })
                ->when($this->filters['part'], function ($query, $search) {
                    return $query->whereHas('part', function ($partQuery) use ($search) {
                        $partQuery->where('name', 'LIKE', '%' . $search . '%');
                    });
                })
                ->when($this->filters['site'], function ($query, $search) {
                    return $query->whereHas('part.site', function ($partQuery) use ($search) {
                        $partQuery->where('name', 'LIKE', '%' . $search . '%');
                    });
                })
                ->when($this->filters['user'], function ($query, $search) {
                    return $query->whereHas('user', function ($partQuery) use ($search) {
                        $partQuery->where('first_name', 'LIKE', '%' . $search . '%')
                            ->orWhere('last_name', 'LIKE', '%' . $search . '%');
                    });
                })
                ->when($this->filters['description'], fn($query, $search) => $query->where('description', 'LIKE', '%' . $search . '%'))
                ->when($this->filters['number_min'], fn($query, $search) => $query->where('number', '>=', $search))
                ->when($this->filters['number_max'], fn($query, $search) => $query->where('number', '<=', $search))
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
        $this->authorize('create', PartExit::class);

        $this->isCreating = true;
        $this->useCachedRows();

        $this->form->reset();
        $this->form->isCreating = true;

        if ($this->isPartVerified) {
            $this->form->part_id = (int)$this->partId;
        }

        $this->searchPart();
        $this->searchMaintenance();

        $this->showModal = true;
    }

    /**
     * Set the model (used in modal) to the partExit we want to edit.
     *
     * @param PartExit $partExit The partExit id to update.
     * (Livewire will automatically fetch the model by the id)
     *
     * @return void
     */
    public function edit(PartExit $partExit): void
    {
        $this->authorize('update', $partExit);

        $this->isCreating = false;
        $this->useCachedRows();

        $this->form->setPartExit($partExit);
        $this->form->isCreating = false;

        $this->searchPart();
        $this->searchMaintenance();

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
            $this->authorize('create', PartExit::class) :
            $this->authorize('update', $this->form->partExit);

        $this->validate();

        $model = $this->isCreating ? $this->form->store() : $this->form->update();

        $this->success($this->flashMessages[$this->isCreating ? 'create' : 'update']['success'], ['name' => $model->part->name]);

        $this->showModal = false;
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
        $selectedOption = Part::where('id', $this->form->part_id)->get();

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

    /**
     * Function to search maintenances in form.
     *
     * @param string $value
     *
     * @return void
     */
    public function searchMaintenance(string $value = ''): void
    {
        // Besides the search results, you must include on demand selected option
        $selectedOption = Maintenance::where('id', $this->form->maintenance_id)->get();

        $maintenances = Maintenance::query()
            ->with(['material'])
            ->whereHas('material', function ($query) use ($value) {
                $query->where('name', 'LIKE', '%' . $value . '%');
            })
            //->where('id', 'like', "%$value%")
            ->whereRelation('material.zone.site', 'id', getPermissionsTeamId());

        $maintenances = $maintenances->take(10)
            ->orderByDesc('id')
            ->get()
            ->merge($selectedOption);

        $this->form->maintenancesSearchable = $maintenances;
    }

    /**
     * Export the selected rows into an Excel file.
     *
     * @return BinaryFileResponse
     *
     * @throws \PhpOffice\PhpSpreadsheet\Exception
     * @throws \PhpOffice\PhpSpreadsheet\Writer\Exception
     */
    public function exportSelected(): BinaryFileResponse
    {
        $this->authorize('export', PartExit::class);

        $site = Site::find(getPermissionsTeamId(), ['id', 'name']);

        return Excel::download(
            new PartExitsExport(
                $this->selectedRowsQuery->get()->pluck('id')->toArray(),
                $this->sortField,
                $this->sortDirection,
                $site
            ),
            'pieces-detachees-sorties-' . Str::slug($site->name) . '.xlsx'
        );
    }
}
