<?php

namespace BDS\Livewire;

use BDS\Livewire\Forms\CleaningForm;
use BDS\Livewire\Traits\WithBulkActions;
use BDS\Livewire\Traits\WithCachedRows;
use BDS\Livewire\Traits\WithFilters;
use BDS\Livewire\Traits\WithPerPagePagination;
use BDS\Livewire\Traits\WithSorting;
use BDS\Livewire\Traits\WithToast;
use BDS\Models\Cleaning;
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
        'qrcode',
        'qrcodeId',
        'filters',
    ];

    /**
     * Whatever the QR COde is set or not.
     *
     * @var bool
     */
    public bool $qrcode = false;

    /**
     * The QR Code id if set.
     *
     * @var int|null
     */
    public ?int $qrcodeId = null;

    /**
     * Filters used for advanced search.
     *
     * @var array
     */
    public array $filters = [
        'id' => '',
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
     * Used to set to show/hide the advanced filters.
     *
     * @var bool
     */
    public bool $showFilters = false;

    /**
     * Number of rows displayed on a page.
     *
     * @var int
     */
    public int $perPage = 25;

    /**
     * Translated attribute used in failed messages.
     *
     * @var string[]
     */
    protected array $validationAttributes = [
        'form.material_id' => 'matériel',
        'form.description' => 'description',
        'form.type' => 'type'
    ];

    /**
     * The Livewire Component constructor.
     *
     * @return void
     */
    public function mount(): void
    {
        if ($this->qrcode === true && $this->qrcodeid !== null) {
            $this->form->material_id = $this->qrcodeid;

            $this->create();
        }
    }

    /**
     * Rules used for validating the model.
     *
     * @return string[]
     */
    public function rules(): array
    {
        return [
            'form.material_id' => 'required|exists:materials,id',
            'form.description' => 'nullable',
            'form.type' => 'required|in:' . collect(Cleaning::TYPES)->keys()->implode(','),
        ];
    }

    /**
     * Function to render the component.
     *
     * @return View
     */
    public function render(): View
    {
        return view('livewire.cleanings', [
            'cleanings' => $this->rows,
            'materials' => Material::query()
                ->with(['zone' => function ($query) {
                    $query->select('id', 'name');
                }])
                ->whereRelation('zone.site', 'id', session('current_site_id'))
                ->select(['id', 'name', 'zone_id'])
                ->orderBy('zone_id')
                ->get()
                ->toArray(),
            'users' => User::pluck('username', 'id')->toArray(),
            'zones' => Zone::pluck('name', 'id')->toArray(),
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
            ->with('material', 'user', 'material.zone', 'material.zone.site')
            ->whereRelation('material.zone.site', 'id', session('current_site_id'))
            ->when($this->filters['id'], fn($query, $id) => $query->where('id', $id))
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
            ->when($this->filters['type'], function ($query, $search) {
                if ($search !== 'Tous') {
                    return $query->where('type', $search);
                }
                return $query;
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
        $this->authorize('create', Cleaning::class);

        $this->isCreating = true;
        $this->useCachedRows();

        $this->form->reset();

        if ($this->qrcode === true && $this->qrcodeid !== null) {
            $this->form->material_id = $this->qrcodeid;
            $this->reset('qrcode', 'qrcodeid');
        }

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
        $this->authorize('update', Cleaning::class);

        $this->isCreating = false;
        $this->useCachedRows();

        $this->form->setCleaning($cleaning);

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
}
