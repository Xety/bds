<?php

namespace BDS\Livewire;

use BDS\Exports\SuppliersExport;
use BDS\Livewire\Forms\SupplierForm;
use BDS\Livewire\Traits\WithBulkActions;
use BDS\Livewire\Traits\WithCachedRows;
use BDS\Livewire\Traits\WithFilters;
use BDS\Livewire\Traits\WithPerPagePagination;
use BDS\Livewire\Traits\WithSorting;
use BDS\Livewire\Traits\WithToast;
use BDS\Models\Site;
use BDS\Models\Supplier;
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

class Suppliers extends Component
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
    public string $model = Supplier::class;

    /**
     * The form used to create/update a cleaning.
     *
     * @var SupplierForm
     */
    public SupplierForm $form;

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
        'site' => '',
        'user' => '',
        'description' => '',
        'created_min' => '',
        'created_max' => '',
    ];

    /**
     * Array of allowed fields.
     *
     * @var array
     */
    public array $allowedFields = [
        'name',
        'site_id',
        'user_id',
        'description',
        'part_count',
        'created_at'
    ];

    /**
     * Flash messages for the model.
     *
     * @var array
     */
    protected array $flashMessages = [
        'create' => [
            'success' => "Le fournisseur n°<b>:name</b> a été créé avec succès !",
            'danger' => "Une erreur s'est produite lors de la création du fournisseur !"
        ],
        'update' => [
            'success' => "Le fournisseur n°<b>:name</b> a été édité avec succès !",
            'danger' => "Une erreur s'est produite lors de l'édition du fournisseur !"
        ],
        'delete' => [
            'success' => "<b>:count</b> fournisseur(s) ont été supprimé(s) avec succès !",
            'danger' => "Une erreur s'est produite lors de la suppression des fournisseurs !"
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
     * Function to render the component.
     *
     * @return View
     */
    public function render(): View
    {
        return view('livewire.suppliers', [
            'suppliers' => $this->rows
        ]);
    }

    /**
     * Create and return the query for the items.
     *
     * @return Builder
     */
    public function getRowsQueryProperty(): Builder
    {
        $query = Supplier::query()
            ->with('site', 'user');

        if (getPermissionsTeamId() !== settings('site_id_verdun_siege')) {
            $query->where('site_id', getPermissionsTeamId());
        }

        if (Gate::allows('search', Supplier::class)) {
            // This filter is only present on Verdun Siege site.
            if(getPermissionsTeamId() === settings('site_id_verdun_siege')){
                $query->when($this->filters['site'], function ($query, $search) {
                    return $query->whereHas('site', function ($partQuery) use ($search) {
                        $partQuery->where('name', 'LIKE', '%' . $search . '%');
                    });
                });
            }

            $query->when($this->filters['name'], fn($query, $name) => $query->where('name', 'LIKE', '%' . $name . '%'))
                ->when($this->filters['user'], function ($query, $search) {
                    return $query->whereHas('user', function ($partQuery) use ($search) {
                        $partQuery->where('first_name', 'LIKE', '%' . $search . '%')
                            ->orWhere('last_name', 'LIKE', '%' . $search . '%');
                    });
                })
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
        $this->authorize('create', Supplier::class);

        $this->isCreating = true;
        $this->useCachedRows();

        $this->form->reset();

        $this->showModal = true;
    }

    /**
     * Set the model (used in modal) to the supplier we want to edit.
     *
     * @param Supplier $supplier The supplier id to update.
     * (Livewire will automatically fetch the model by the id)
     *
     * @return void
     */
    public function edit(Supplier $supplier): void
    {
        $this->authorize('update', $supplier);

        $this->isCreating = false;
        $this->useCachedRows();

        $this->form->setSupplier($supplier);

        $this->showModal = true;
    }

    /**
     * Validate and save the model.
     *
     * @return void
     */
    public function save(): void
    {
        $this->authorize($this->isCreating ? 'create' : 'update', Supplier::class);

        $this->validate();

        $model = $this->isCreating ? $this->form->store() : $this->form->update();

        $this->success($this->flashMessages[$this->isCreating ? 'create' : 'update']['success'], ['name' => $model->name]);

        $this->showModal = false;
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
        $this->authorize('export', Supplier::class);

        $site = Site::find(getPermissionsTeamId(), ['id', 'name']);

        return Excel::download(
            new SuppliersExport(
                $this->selectedRowsQuery->get()->pluck('id')->toArray(),
                $this->sortField,
                $this->sortDirection,
                $site
            ),
            'fournisseurs-' . Str::slug($site->name) . '.xlsx'
        );
    }
}
