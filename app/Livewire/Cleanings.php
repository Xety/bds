<?php

namespace BDS\Livewire;

use BDS\Exports\CleaningsExport;
use BDS\Livewire\Forms\CleaningForm;
use BDS\Livewire\Traits\WithBulkActions;
use BDS\Livewire\Traits\WithCachedRows;
use BDS\Livewire\Traits\WithFilters;
use BDS\Livewire\Traits\WithPerPagePagination;
use BDS\Livewire\Traits\WithSorting;
use BDS\Livewire\Traits\WithToast;
use BDS\Models\Cleaning;
use BDS\Models\Material;
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

class Cleanings extends Component
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
    public string $model = Cleaning::class;

    /**
     * The form used to create/update a cleaning.
     *
     * @var CleaningForm
     */
    public CleaningForm $form;

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
    protected array $queryString = [
        'sortField' => ['as' => 'f'],
        'sortDirection' => ['as' => 'd'],
        'creating',
        'materialId',
        'filters',
    ];

    /**
     * Whatever the QR COde is set or not.
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
     * Whatever the selected material has enabled the PH test when creating/editing
     * a cleaning.
     *
     * @var bool
     */
    public bool $materialCleaningTestPhEnabled = false;

    /**
     * Filters used for advanced search.
     *
     * @var array
     */
    public array $filters = [
        'id' => '',
        'site' => '',
        'material' => '',
        'zone' => '',
        'creator' => '',
        'description' => '',
        'type' => '',
        'created_min' => '',
        'created_max' => '',
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
        'type',
        'created_at'
    ];

    /**
     * Flash messages for the model.
     *
     * @var array
     */
    protected array $flashMessages = [
        'create' => [
            'success' => "Le nettoyage n°<b>:id</b> a été créé avec succès !",
            'danger' => "Une erreur s'est produite lors de la création du nettoyage !"
        ],
        'update' => [
            'success' => "Le nettoyage n°<b>:id</b> a été édité avec succès !",
            'danger' => "Une erreur s'est produite lors de l'édition du nettoyage !"
        ],
        'delete' => [
            'success' => "<b>:count</b> nettoyage(s) ont été supprimé(s) avec succès !",
            'danger' => "Une erreur s'est produite lors de la suppression des nettoyages !"
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
                $this->create();

                $this->form->material_id = $material->id;

                $this->search();
            }
        }
    }

    /**
     * Update the variable whenever the form is updated.
     *
     * @return void
     */
    public function updatedForm(): void
    {
        $material = Material::find($this->form->material_id);
        $this->materialCleaningTestPhEnabled = !is_null($material) && $material->selvah_cleaning_test_ph_enabled;
    }

    /**
     * Function to render the component.
     *
     * @return View
     */
    public function render(): View
    {
        return view('livewire.cleanings', [
            'cleanings' => $this->rows
        ]);
    }

    /**
     * Create and return the query for the items.
     *
     * @return Builder
     */
    public function getRowsQueryProperty(): Builder
    {
        $query = Cleaning::query()
            ->with('material', 'user', 'material.zone', 'site');

        if (getPermissionsTeamId() !== settings('site_id_verdun_siege')) {
            $query->where('site_id', getPermissionsTeamId());
        }

        if (Gate::allows('search', Cleaning::class)) {
            $query->when($this->filters['id'], fn($query, $id) => $query->where('id', $id))
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
                ->when($this->filters['type'], fn ($query, $search) => $query->where('type', $search))
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
        $this->authorize('create', Cleaning::class);

        $this->isCreating = true;
        $this->useCachedRows();

        $this->form->reset();
        $this->search();

        $this->showModal = true;
    }

    /**
     * Set the model (used in modal) to the cleaning we want to edit.
     *
     * @param Cleaning $cleaning The cleaning id to update.
     * (Livewire will automatically fetch the model by the id)
     *
     * @return void
     */
    public function edit(Cleaning $cleaning): void
    {
        $this->authorize('update', $cleaning);

        $this->isCreating = false;
        $this->useCachedRows();

        $this->form->setCleaning($cleaning);
        $this->updatedForm();
        $this->search();

        $this->showModal = true;
    }

    /**
     * Validate and save the model.
     *
     * @return void
     */
    public function save(): void
    {
        $this->authorize($this->isCreating ? 'create' : 'update', Cleaning::class);

        $this->validate();

        $model = $this->isCreating ? $this->form->store() : $this->form->update();

        $this->success($this->flashMessages[$this->isCreating ? 'create' : 'update']['success'], ['id' => $model->getKey()]);

        $this->showModal = false;
    }

    /**
     * Function to search materials in form.
     *
     * @param string $value
     *
     * @return void
     */
    public function search(string $value = ''): void
    {
        $selectedOption = Material::where('id', $this->form->material_id)->get();

        $materials = Material::query()
            ->with(['zone', 'zone.site'])
            ->where('name', 'like', "%$value%")
            ->whereRelation('zone.site', 'id', getPermissionsTeamId());

        $materials = $materials->take(5)
            ->orderBy('name')
            ->get()
            ->merge($selectedOption);

        $this->form->materialsSearchable = $materials;
    }

    public function exportSelected()
    {
        $site = Site::find(getPermissionsTeamId(), ['id', 'name']);
        //dd($this->selectedRowsQuery->get()->pluck('id')->toArray());
        return Excel::download(
            new CleaningsExport(
                $this->selectedRowsQuery->get()->pluck('id')->toArray(),
                $this->sortField,
                $this->sortDirection,
                $site
            ),
            'nettoyages-' . Str::slug($site->name) . '.xlsx'
        );
    }
}
