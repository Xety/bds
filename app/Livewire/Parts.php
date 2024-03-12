<?php

namespace BDS\Livewire;

use BDS\Models\Site;
use BDS\Models\Supplier;
use Carbon\Carbon;
use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;
use Livewire\WithPagination;
use ReflectionException;
use BDS\Livewire\Forms\PartForm;
use BDS\Livewire\Traits\WithBulkActions;
use BDS\Livewire\Traits\WithCachedRows;
use BDS\Livewire\Traits\WithFilters;
use BDS\Livewire\Traits\WithPerPagePagination;
use BDS\Livewire\Traits\WithQrCode;
use BDS\Livewire\Traits\WithSorting;
use BDS\Livewire\Traits\WithToast;
use BDS\Models\Material;
use BDS\Models\Part;
use BDS\Models\User;

class Parts extends Component
{
    use AuthorizesRequests;
    use WithBulkActions;
    use WithCachedRows;
    use WithFilters;
    use WithPagination;
    use WithPerPagePagination;
    use WithQrCode;
    use WithSorting;
    use WithToast;

    /**
     * Bind the main model used in the component to be used in traits.
     *
     * @var string
     */
    public string $model = Part::class;

    /**
     * The form used to create/update a model.
     *
     * @var PartForm
     */
    public PartForm $form;

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
        'qrcode',
        'partId',
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
        'creator' => '',
        'description' => '',
        'reference' => '',
        'supplier' => '',
        'price_min' => '',
        'price_max' => '',
        'number_warning_enabled' => '',
        'number_critical_enabled' => '',
        'material_min' => '',
        'material_max' => '',
        'part_entry_min' => '',
        'part_entry_max' => '',
        'part_exit_min' => '',
        'part_exit_max' => '',
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
        'description',
        'user_id',
        'reference',
        'supplier_id',
        'price',
        'number_warning_enabled',
        'number_critical_enabled',
        'part_entry_count',
        'part_exit_count',
        'material_count',
        'created_at'
    ];

    /**
     * Whatever the editing url param is set or not.
     *
     * @var bool
     */
    public bool|string $editing = '';

    /**
     * Whatever the QR Code url param is set or not.
     *
     * @var bool
     */
    public bool|string $qrcode = '';

    /**
     * The part id if set.
     *
     * @var null|int
     */
    public null|int $partId = null;

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
     * Whatever the option to view part from other site is enabled/disabled.
     *
     * @var bool
     */
    public bool $viewOtherSitePart = false;

    /**
     * Flash messages for the model.
     *
     * @var array
     */
    protected array $flashMessages = [
        'create' => [
            'success' => "La pièce détachée <b>:name</b> a été créé avec succès !",
            'danger' => "Une erreur s'est produite lors de la création de la pièce détachée !"
        ],
        'update' => [
            'success' => "La pièce détachée <b>:name</b> a été édité avec succès !",
            'danger' => "Une erreur s'est produite lors de l'édition de la pièce détachée !"
        ],
        'delete' => [
            'success' => "<b>:count</b> pièce(s) détachée(s) ont été supprimée(s) avec succès !",
            'danger' => "Une erreur s'est produite lors de la suppression des pièces détachées !"
        ]
    ];

    /**
     * The Livewire Component constructor.
     *
     * @return void
     *
     * @throws ReflectionException
     */
    public function mount(): void
    {
        // Set the view other site part to true by default for maintenance site only.
        if (Gate::allows('viewOtherSite', Part::class) &&
            (getPermissionsTeamId() === settings('site_id_maintenance_bds') ||
            getPermissionsTeamId() === settings('site_id_verdun_siege'))) {
            $this->viewOtherSitePart = true;
        }

        // Check if the edit option are set into the url, and if yes, open the Edit Modal if the user has the permissions.
        if ($this->editing === true && $this->partId !== null) {
            $part = Part::whereId($this->partId)
                ->where('site_id', getPermissionsTeamId())
                ->first();

            if ($part) {
                $this->edit($part);
            }
        }

        // Check if the qrcode option are set into the url, and if yes, open the QR Code Modal if the user has the permissions.
        if ($this->qrcode === true && $this->partId !== null) {
            // Display the modal of the Material ONLY on the site where the material belong to.
            $part = Part::whereId($this->partId)
                ->where('site_id', getPermissionsTeamId())
                ->first();

            if ($part) {
                $this->showQrCode($part);
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
        $suppliers = Supplier::query()
            ->where('site_id', getPermissionsTeamId())
            ->select(['id', 'name', 'site_id'])
            ->orderBy('name')
            ->get()
            ->toArray();

        //array_unshift($suppliers, ['id' => '', 'name' => 'Aucun fournisseur']);

        return view('livewire.parts', [
            'parts' => $this->rows,
            'suppliers' => $suppliers,
        ]);
    }

    /**
     * Create and return the query for the items.
     *
     * @return Builder
     */
    public function getRowsQueryProperty(): Builder
    {
        $query = Part::query()
            ->with(['materials', 'user', 'site', 'supplier']);

        // If the user does not have the permissions to see parts from other site
        // add a where condition to display only the part from the current site.
        if (!Gate::allows('viewOtherSite', Part::class) || !$this->viewOtherSitePart) {
            $query->where('site_id', getPermissionsTeamId());
        }


        if (Gate::allows('search', Part::class)) {
            $query
                ->when($this->filters['name'], fn($query, $search) => $query->where('name', 'LIKE', '%' . $search . '%'))
                ->when($this->filters['site'], function ($query, $search) {
                    return $query->whereHas('site', function ($partQuery) use ($search) {
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
                ->when($this->filters['reference'], fn($query, $search) => $query->where('reference', 'LIKE', '%' . $search . '%'))
                ->when($this->filters['supplier'], function ($query, $search) {
                    return $query->whereHas('supplier', function ($partQuery) use ($search) {
                        $partQuery->where('name', 'LIKE', '%' . $search . '%');
                    });
                })
                ->when($this->filters['price_min'], fn($query, $search) => $query->where('price', '>=', $search))
                ->when($this->filters['price_max'], fn($query, $search) => $query->where('price', '<=', $search))
                ->when($this->filters['number_warning_enabled'], function ($query, $search) {
                    if ($search === 'yes') {
                        return $query->where('number_warning_enabled', true);
                    }
                    return $query->where('number_warning_enabled', false);
                })
                ->when($this->filters['number_critical_enabled'], function ($query, $search) {
                    if ($search === 'yes') {
                        return $query->where('number_critical_enabled', true);
                    }
                    return $query->where('number_critical_enabled', false);
                })
                ->when($this->filters['material_min'], fn($query, $search) => $query->where('material_count', '>=', $search))
                ->when($this->filters['material_max'], fn($query, $search) => $query->where('material_count', '<=', $search))
                ->when($this->filters['part_entry_min'], fn($query, $search) => $query->where('part_entry_count', '>=', $search))
                ->when($this->filters['part_entry_max'], fn($query, $search) => $query->where('part_entry_count', '<=', $search))
                ->when($this->filters['part_exit_min'], fn($query, $search) => $query->where('part_exit_count', '>=', $search))
                ->when($this->filters['part_exit_max'], fn($query, $search) => $query->where('part_exit_count', '<=', $search))
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
        $this->authorize('create', Part::class);

        $this->isCreating = true;
        $this->useCachedRows();

        $this->form->reset();
        $this->searchMaterials();
        $this->searchRecipients();

        $this->showModal = true;
    }

    /**
     * Set the model (used in modal) to the part we want to edit.
     *
     * @param Part $part The part id to update.
     * (Livewire will automatically fetch the model by the id)
     *
     * @return void
     */
    public function edit(Part $part): void
    {
        $this->authorize('update', $part);

        $this->isCreating = false;
        $this->useCachedRows();

        $materials = $part->materials()->pluck('id')->toArray();
        $recipients = $part->recipients()->pluck('id')->toArray();

        $this->form->setPart($part, $materials, $recipients);
        $this->searchMaterials();
        $this->searchRecipients();

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
            $this->authorize('create', Material::class) :
            $this->authorize('update', $this->form->part);

        $this->validate();

        $model = $this->isCreating ? $this->form->store() : $this->form->update();

        $this->success($this->flashMessages[$this->isCreating ? 'create' : 'update']['success'], ['name' => $model->name]);

        $this->showModal = false;
    }

    /**
     * Verify the id of the material then display the QRCode modal.
     *
     * @param int $model The model id of the material.
     *
     * @return void
     *
     * @throws ReflectionException
     */
    public function displayQrCode(int $model): void
    {
        // Display the modal of the Material ONLY on the site where the material belong to.
        $part = Part::whereId($model)
            ->where('site_id', getPermissionsTeamId())
            ->first();

        if ($part) {
            $this->showQrCode($part);
        }
    }

    /**
     * Function to search materials in form.
     *
     * @param string $value
     *
     * @return void
     */
    public function searchMaterials(string $value = ''): void
    {
        // Besides the search results, you must include on demand selected option
        $selectedOption = Material::whereIn('id', $this->form->materials)->get();

        $materials = Material::query()
            ->with(['zone', 'zone.site'])
            ->where('name', 'like', "$value%");

        // Only the maintenance site can access to all materials from all sites.
        if(getPermissionsTeamId() !== settings('site_id_maintenance_bds')) {
            $materials->whereRelation('zone.site', 'id', getPermissionsTeamId());
        }

        $materials = $materials->take(10)
            ->orderBy('name')
            ->get()
            ->merge($selectedOption);

        $this->form->materialsMultiSearchable = $materials;
    }

    /**
     * Function to search recipients in form.
     *
     * @param string $value
     *
     * @return void
     */
    public function searchRecipients(string $value = ''): void
    {
        // Besides the search results, you must include on demand selected option
        if (!empty($this->form->recipients)) {
            $selectedOption = User::whereIn('id', $this->form->recipients)->get();
        } else {
            $selectedOption = [];
        }

        $recipients = User::query()
            ->with(['roles', 'sites'])
            ->whereRelation('sites', 'site_id', getPermissionsTeamId())
            ->where(function($query) use ($value) {
                return $query->where('first_name', 'like', "%$value%")
                    ->orWhere('last_name', 'like', "%$value%");
            });

        $recipients = $recipients->take(10)
            ->orderBy('username')
            ->get()
            ->merge($selectedOption);

        $this->form->recipientsMultiSearchable = $recipients;
    }
}
