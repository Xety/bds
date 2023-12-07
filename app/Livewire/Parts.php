<?php

namespace BDS\Livewire;

use Carbon\Carbon;
use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
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
     * The form used to create/update a user.
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
        'creator' => '',
        'material' => '',
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
        'name',
        'description',
        'user_id',
        'reference',
        'supplier',
        'price',
        'number_warning_enabled',
        'number_critical_enabled',
        'part_entry_count',
        'part_exit_count',
        'material_count',
        'created_at'
    ];

    /**
     * Whatever the Editing url param is set or not.
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
        // Check if the edit option are set into the url, and if yes, open the Edit Modal if the user has the permissions.
        if ($this->editing === true && $this->partId !== null) {
            $part = Part::whereId($this->partId)->first();

            if ($part) {
                $this->edit($part);
            }
        }

        // Check if the qrcode option are set into the url, and if yes, open the QR Code Modal if the user has the permissions.
        if ($this->qrcode === true && $this->partId !== null) {
            // Display the modal of the Material ONLY on the site where the material belong to.
            $part = Part::whereId($this->partId)
                //->whereRelation('zone.site', 'id', session('current_site_id'))
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
        return view('livewire.parts', [
            'parts' => $this->rows,
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
            ->with('materials', 'user');
            /*->when($this->filters['creator'], fn($query, $creator) => $query->where('user_id', $creator))
            ->when($this->filters['created-min'], fn($query, $date) => $query->where('created_at', '>=', Carbon::parse($date)))
            ->when($this->filters['created-max'], fn($query, $date) => $query->where('created_at', '<=', Carbon::parse($date)));*/

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

        $this->form->setPart($part);

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

}
