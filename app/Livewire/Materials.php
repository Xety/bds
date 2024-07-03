<?php

namespace BDS\Livewire;

use BDS\Exports\MaterialsExport;
use BDS\Livewire\Forms\MaterialForm;
use BDS\Livewire\Traits\WithBulkActions;
use BDS\Livewire\Traits\WithCachedRows;
use BDS\Livewire\Traits\WithFilters;
use BDS\Livewire\Traits\WithPerPagePagination;
use BDS\Livewire\Traits\WithQrCode;
use BDS\Livewire\Traits\WithSorting;
use BDS\Livewire\Traits\WithToast;
use BDS\Models\Material;
use BDS\Models\Part;
use BDS\Models\Site;
use BDS\Models\User;
use BDS\Models\Zone;
use Carbon\Carbon;
use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;
use ReflectionException;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class Materials extends Component
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
    public string $model = Material::class;

    /**
     * The form used to create/update a user.
     *
     * @var MaterialForm
     */
    public MaterialForm $form;

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
    public string $sortDirection = 'asc';

    /**
     * Used to update in URL the query string.
     *
     * @var string[]
     */
    protected $queryString = [
        'sortField' => ['as' => 'f'],
        'sortDirection' => ['as' => 'd'],
        'creating',
        'editing',
        'qrcode',
        'materialId',
        'zoneId',
        'filters',
    ];

    /**
     * Filters used for advanced search.
     *
     * @var array
     */
    public array $filters = [
        'id' => '',
        'name' => '',
        'zone' => '',
        'creator' => '',
        'description' => '',
        'cleaning_alert' => '',
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
        'user_id',
        'name',
        'description',
        'zone_id',
        'incident_count',
        'part_count',
        'maintenance_count',
        'cleaning_count',
        'cleaning_alert',
        'created_at'
    ];

    /**
     * Whatever the Editing url param is set or not.
     *
     * @var bool
     */
    public bool|string $editing = '';

    /**
     * Whatever the Creating url param is set or not.
     *
     * @var bool
     */
    public bool|string $creating = '';

    /**
     * Whatever the QR Code url param is set or not.
     *
     * @var bool
     */
    public bool|string $qrcode = '';

    /**
     * The material id if set.
     *
     * @var null|int
     */
    public null|int $materialId = null;

    /**
     * The zone id if set.
     *
     * @var null|int
     */
    public null|int $zoneId = null;

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
     * Flash messages for the model.
     *
     * @var array
     */
    protected array $flashMessages = [
        'create' => [
            'success' => "Le matériel <b>:name</b> a été créé avec succès !",
            'danger' => "Une erreur s'est produite lors de la création du matériel !"
        ],
        'update' => [
            'success' => "Le matériel <b>:name</b> a été édité avec succès !",
            'danger' => "Une erreur s'est produite lors de l'édition du matériel !"
        ],
        'delete' => [
            'success' => "<b>:count</b> matériel(s) ont été supprimé(s) avec succès !",
            'danger' => "Une erreur s'est produite lors de la suppression des matériels !"
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
        // Check if the edit option are set into the url, and if yes, open the Edit Modal if the user has the permissions.
        if ($this->editing === true && $this->materialId !== null) {
            $material = Material::whereId($this->materialId)->first();

            if ($material) {
                $this->edit($material);
            }
        }

        // If the Creating URL param is set, open the create modal.
        if ($this->creating === true && $this->zoneId !== null) {
            $zone = Zone::whereId($this->zoneId)->first();

            if ($zone) {
                $this->create($zone);
            }
        }

        // Check if the qrcode option are set into the url, and if yes, open the QR Code Modal if the user has the permissions.
        if ($this->qrcode === true && $this->materialId !== null) {
            // Display the modal of the Material ONLY on the site where the material belong to.
            $material = Material::whereId($this->materialId)
                ->whereRelation('zone.site', 'id', getPermissionsTeamId())
                ->first();

            if ($material) {
                $this->showQrCode($material);
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
        return view('livewire.materials', [
            'materials' => $this->rows,
            'users' => User::pluck('username', 'id')->toArray(),
            'zones' => Zone::where('site_id', getPermissionsTeamId())
                ->where('allow_material', true)
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
        $query = Material::query()
            ->with('zone', 'user')
            ->whereRelation('zone.site', 'id', getPermissionsTeamId());

            if (Gate::allows('search', Material::class)) {
                $query->when($this->filters['id'], fn($query, $id) => $query->where('id', $id))
                    ->when($this->filters['name'], fn($query, $name) => $query->where('name', 'LIKE', '%' . $name . '%'))
                    ->when($this->filters['zone'], function ($query, $search) {
                        return $query->whereHas('zone', function ($partQuery) use ($search) {
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
                    ->when($this->filters['cleaning_alert'], function ($query, $search) {
                        if ($search === 'yes') {
                            return $query->where('cleaning_alert', true);
                        }
                        return $query->where('cleaning_alert', false);
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
     * @param Zone|null $zone The zone id to set if specified.
     *
     * @return void
     */
    public function create(Zone $zone = null): void
    {
        $this->authorize('create', Material::class);

        $this->isCreating = true;
        $this->useCachedRows();

        $this->form->reset();
        $this->form->zone_id = $zone->id;
        $this->searchRecipients();

        $this->showModal = true;
    }

    /**
     * Set the model (used in modal) to the material we want to edit.
     *
     * @param Material $material The material id to update.
     * (Livewire will automatically fetch the model by the id)
     *
     * @return void
     */
    public function edit(Material $material): void
    {
        $this->authorize('update', $material);

        $this->isCreating = false;
        $this->useCachedRows();

        $recipients = $material->recipients()->pluck('id')->toArray();

        $this->form->setMaterial($material, $recipients);
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
            $this->authorize('update', $this->form->material);

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
        $material = Material::whereId($model)
            ->whereRelation('zone.site', 'id', getPermissionsTeamId())
            ->first();

        if ($material) {
            $this->showQrCode($material);
        }
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

        $recipients = $recipients->take(5)
            ->orderBy('first_name')
            ->get()
            ->merge($selectedOption);

        $this->form->recipientsMultiSearchable = $recipients;
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
        $this->authorize('export', Material::class);

        $site = Site::find(getPermissionsTeamId(), ['id', 'name']);

        return Excel::download(
            new MaterialsExport(
                $this->selectedRowsQuery->get()->pluck('id')->toArray(),
                $this->sortField,
                $this->sortDirection,
                $site
            ),
            'materiels-' . Str::slug($site->name) . '.xlsx'
        );
    }
}
