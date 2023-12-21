<?php

namespace BDS\Livewire;

use BDS\Livewire\Forms\PartEntryForm;
use BDS\Livewire\Traits\WithFilters;
use BDS\Livewire\Traits\WithToast;
use Carbon\Carbon;
use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;
use Livewire\WithPagination;
use BDS\Livewire\Traits\WithCachedRows;
use BDS\Livewire\Traits\WithSorting;
use BDS\Livewire\Traits\WithBulkActions;
use BDS\Livewire\Traits\WithPerPagePagination;
use BDS\Models\Part;
use BDS\Models\PartEntry;

class PartEntries extends Component
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
    public string $model = PartEntry::class;

    /**
     * The form used to create/update a part entry.
     *
     * @var PartEntryForm
     */
    public PartEntryForm $form;

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
        'part' => '',
        'site' => '',
        'user' => '',
        'number_min' => '',
        'number_max' => '',
        'order' => '',
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
     * Array of allowed fields.
     *
     * @var array
     */
    public array $allowedFields = [
        'part_id',
        'user_id',
        'number',
        'order_id',
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
    public bool $viewOtherSitePartEntry = false;

    /**
     * Flash messages for the model.
     *
     * @var array
     */
    protected array $flashMessages = [
        'create' => [
            'success' => "L'entrée pour la pièce <b>:name</b> a été créé avec succès !",
            'danger' => "Une erreur s'est produite lors de la création de l'entrée."
        ],
        'update' => [
            'success' => "L'entrée pour la pièce <b>:name</b> a été édité avec succès !",
            'danger' => "Une erreur s'est produite lors de l'édition de l'entrée."
        ],
        'delete' => [
            'success' => "<b>:count</b> entrée(s) ont été supprimée(s) avec succès !",
            'danger' => "Une erreur s'est produite lors de la suppression des entrées !"
        ]
    ];

    /**
     * The Livewire Component constructor.
     *
     * @return void
     */
    public function mount(): void
    {
        // Check if the create option is set into the url, and if yes, open the Create Modal (if the user has the permissions).
        if ($this->creating === true && $this->partId !== null) {
            // Must check the site_id of the part, to be sure the user does not try to use a part from another site.
            $part = Part::whereId($this->partId)->where('site_id', getPermissionsTeamId())->first();

            if ($part) {
                $this->create();

                $this->form->part_id = $part->id;
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
        return view('livewire.part-entries', [
            'partEntries' => $this->rows,
            'parts' => Part::query()
                ->with(['materials' => function ($query) {
                    $query->select('id', 'name');
                }])
                ->select('id', 'name')
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
        $query = PartEntry::query()
            ->with('part', 'user');

        // If the user does not have the permissions to see parts entries from others sites
        // add a where condition to display only the part entries from the current site.
        if (!Gate::allows('viewOtherSite', PartEntry::class) || !$this->viewOtherSitePartEntry) {
            $query->whereHas('part', function ($partQuery) {
                $partQuery->where('site_id', getPermissionsTeamId());
            });
        }

        if (Gate::allows('search', PartEntry::class)) {
            $query
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
                        $partQuery->where('name', 'LIKE', '%' . $search . '%');
                    });
                })
                ->when($this->filters['number_min'], fn($query, $search) => $query->where('number', '>=', $search))
                ->when($this->filters['number_max'], fn($query, $search) => $query->where('number', '<=', $search))
                ->when($this->filters['order'], fn($query, $search) => $query->where('order_id', 'LIKE', '%' . $search . '%'))
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
        $this->authorize('create', PartEntry::class);

        $this->isCreating = true;
        $this->useCachedRows();

        // Reset the model to a blank model before showing the creating modal.
        if ($this->model->getKey()) {
            $this->model = $this->makeBlankModel();
        }
        $this->showModal = true;
    }

    /**
     * Set the model (used in modal) to the partEntry we want to edit.
     *
     * @param PartEntry $partEntry The partEntry id to update.
     * (Livewire will automatically fetch the model by the id)
     *
     * @return void
     */
    public function edit(PartEntry $partEntry): void
    {
        $this->authorize('update', PartEntry::class);

        $this->isCreating = false;
        $this->useCachedRows();

        // Set the model to the part we want to edit.
        if ($this->model->isNot($partEntry)) {
            $this->model = $partEntry;
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
        $this->authorize($this->isCreating ? 'create' : 'update', PartEntry::class);

        $this->validate();

        if ($this->model->save()) {
            $this->fireFlash($this->isCreating ? 'create' : 'update', 'success','', [$this->model->part->name]);
        } else {
            $this->fireFlash($this->isCreating ? 'create' : 'update', 'danger');
        }
        $this->showModal = false;
    }
}
