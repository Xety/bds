<?php

namespace BDS\Livewire;

use BDS\Livewire\Forms\MaterialForm;
use BDS\Livewire\Traits\WithBulkActions;
use BDS\Livewire\Traits\WithCachedRows;
use BDS\Livewire\Traits\WithFilters;
use BDS\Livewire\Traits\WithPerPagePagination;
use BDS\Livewire\Traits\WithQrCode;
use BDS\Livewire\Traits\WithSorting;
use BDS\Livewire\Traits\WithToast;
use BDS\Models\Material;
use BDS\Models\User;
use BDS\Models\Zone;
use Carbon\Carbon;
use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Pagination\LengthAwarePaginator;
use Livewire\Component;
use Livewire\WithPagination;
use ReflectionException;

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
        'editing',
        'editId',
        'qrcode',
        'qrcodeId',
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
     * The Edit id if set.
     *
     * @var null|int
     */
    public null|int $editId = null;

    /**
     * Whatever the QR Code url param is set or not.
     *
     * @var bool
     */
    public bool|string $qrcode = '';

    /**
     * The QR Code id if set.
     *
     * @var null|int
     */
    public null|int $qrcodeId = null;

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
     * Used to set to show/hide the advanced filters.
     *
     * @var bool
     */
    public bool $showFilters = false;

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
        if ($this->editing === true && $this->editId !== null) {
            $material = Material::whereId($this->editId)->first();

            if ($material) {
                $this->edit($material);
            }
        }

        // Check if the qrcode option are set into the url, and if yes, open the QR Code Modal if the user has the permissions.
        if ($this->qrcode === true && $this->qrcodeId !== null) {
            // Display the modal of the Material ONLY on the site where the material belong to.
            $material = Material::whereId($this->qrcodeId)->whereRelation('zone.site', 'id', session('current_site_id'))->first();

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
            'zones' => Zone::where('site_id', session('current_site_id'))
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
            ->whereRelation('zone.site', 'id', session('current_site_id'))
            ->when($this->filters['id'], fn($query, $id) => $query->where('id', $id))
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
        $this->authorize('create', Material::class);

        $this->isCreating = true;
        $this->useCachedRows();

        $this->form->reset();

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

        $this->form->setMaterial($material);

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
}
