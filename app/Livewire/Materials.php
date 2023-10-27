<?php

namespace BDS\Livewire;

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
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;
use OpenSpout\Common\Entity\Cell;
use OpenSpout\Common\Entity\Row;
use OpenSpout\Common\Entity\Style\Border;
use OpenSpout\Common\Entity\Style\BorderPart;
use OpenSpout\Common\Entity\Style\CellAlignment;
use OpenSpout\Common\Entity\Style\CellVerticalAlignment;
use OpenSpout\Common\Entity\Style\Color;
use OpenSpout\Common\Entity\Style\Style;
use OpenSpout\Common\Exception\InvalidArgumentException;
use OpenSpout\Common\Exception\IOException;
use OpenSpout\Writer\Exception\InvalidSheetNameException;
use OpenSpout\Writer\Exception\WriterNotOpenedException;
use OpenSpout\Writer\XLSX\Options;
use OpenSpout\Writer\XLSX\Writer;
use ReflectionException;
use Symfony\Component\HttpFoundation\StreamedResponse;

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
        'edit' => ['except' => ''],
        'editid' => ['except' => ''],
        'qrcode' => ['except' => ''],
        'qrcodeid' => ['except' => ''],
        'filters',
    ];

    /**
     * Filters used for advanced search.
     *
     * @var array
     */
    public array $filters = [
        'search' => '',
        'creator' => '',
        'zone' => '',
        'created-min' => '',
        'created-max' => '',
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
     * The model used in the component.
     *
     * @var Material
     */
    public Material $model;

    /**
     * Whatever the Editing url param is set or not.
     *
     * @var bool
     */
    public bool|string $edit = '';

    /**
     * The Edit id if set.
     *
     * @var null|int
     */
    public null|int $editid = null;

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
    public null|int $qrcodeid = null;

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
     * Translated attribute used in failed messages.
     *
     * @var array
     */
    protected array $validationAttributes = [
        'name' => 'nom',
        'zone_id' => 'zone',
        'cleaning_test_ph_enabled' => 'test de PH',
        'cleaning_alert' => 'alerte de nettoyage',
        'cleaning_alert_email' => 'alerte de nettoyage par email',
        'cleaning_alert_frequency_repeatedly' => 'fréquence de nettoyage',
        'cleaning_alert_frequency_type' => 'type de nettoyage'
    ];

    /**
     * Flash messages for the model.
     *
     * @var array
     */
    protected array $flashMessages = [
        'create' => [
            'success' => "Le matériel <b>%s</b> a été créé avec succès !",
            'danger' => "Une erreur s'est produite lors de la création du matériel !"
        ],
        'update' => [
            'success' => "Le matériel <b>%s</b> a été édité avec succès !",
            'danger' => "Une erreur s'est produite lors de l'édition du matériel !"
        ],
        'delete' => [
            'success' => "<b>%s</b> matériel(s) ont été supprimé(s) avec succès !",
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
        $this->model = $this->makeBlankModel();

        // Check if the edit option are set into the url, and if yes, open the Edit Modal if the user has the permissions.
        if ($this->edit === true && $this->editid !== null && Auth::user()->can('update material')) {
            $model = Material::findOrFail($this->editid);

            $this->edit($model);
        }

        // Check if the qrcode option are set into the url, and if yes, open the QR Code Modal if the user has the permissions.
        if ($this->qrcode === true && $this->qrcodeid !== null && Auth::user()->can('generateQrCode material')) {
            $this->showQrCode($this->qrcodeid);
        }
    }

    /**
     * Rules used for validating the model.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'model.name' => 'required|min:2|unique:materials,name,' . $this->model->id,
            'model.description' => 'required|min:3',
            'model.zone_id' => 'required|exists:zones,id',
            'model.cleaning_test_ph_enabled' => 'required|boolean',
            'model.cleaning_alert' => 'required|boolean',
            'model.cleaning_alert_email' => 'exclude_if:model.cleaning_alert,false|boolean|required',
            'model.cleaning_alert_frequency_repeatedly' => 'exclude_if:model.cleaning_alert,false|numeric|between:1,365|required',
            'model.cleaning_alert_frequency_type' => 'exclude_if:model.cleaning_alert,false|in:' . collect(Material::CLEANING_TYPES)->keys()->implode(',') . '|required',
        ];
    }

    /**
     * Create a blank model and return it.
     *
     * @return Material
     */
    public function makeBlankModel(): Material
    {
       $model = Material::make();
       $model->cleaning_test_ph_enabled = $model->cleaning_test_ph_enabled ?? false;
       $model->cleaning_alert = $model->cleaning_alert ?? false;
       $model->cleaning_alert_email = $model->cleaning_alert_email ?? false;
       $model->cleaning_alert_frequency_repeatedly = $model->cleaning_alert_frequency_repeatedly ?? 0;
        $model->cleaning_alert_frequency_type = $model->cleaning_alert_frequency_type ?? 'daily';

        return $model;
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
            'zones' => Zone::pluck('name', 'id')->toArray()
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
            ->when($this->filters['creator'], fn($query, $creator) => $query->where('user_id', $creator))
            ->when($this->filters['zone'], fn($query, $material) => $query->where('zone_id', $material))
            ->when($this->filters['created-min'], fn($query, $date) => $query->where('created_at', '>=', Carbon::parse($date)))
            ->when($this->filters['created-max'], fn($query, $date) => $query->where('created_at', '<=', Carbon::parse($date)))
            ->when($this->filters['search'], function ($query, $search) {
                $query->where('name', 'like', '%' . $search . '%')
                    ->orWhere('description', 'like', '%' . $search . '%');
        }   );

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

        // Reset the model to a blank model before showing the creating modal.
        if ($this->model->getKey()) {
            $this->model = $this->makeBlankModel();
        }
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
        $this->authorize('update', Material::class);

        $this->isCreating = false;
        $this->useCachedRows();

        // Set the model to the material we want to edit.
        if ($this->model->isNot($material)) {
            $this->model = $material;
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
        $this->authorize($this->isCreating ? 'create' : 'update', Material::class);

        $this->validate();

        if ($this->model->save()) {
            $this->fireFlash($this->isCreating ? 'create' : 'update', 'success', '', [$this->model->name]);
        } else {
            $this->fireFlash($this->isCreating ? 'create' : 'update', 'danger');
        }
        $this->showModal = false;
    }

    /**
     * Export the selected rows to an Excel file with formatted content.
     *
     * @return StreamedResponse
     *
     * @throws IOException
     * @throws InvalidArgumentException
     * @throws WriterNotOpenedException
     * @throws InvalidSheetNameException
     */
    public function exportSelected(): StreamedResponse
    {
        $this->authorize('export', Material::class);

        $fileName = 'materiels.xlsx';

        $options = new Options();
        $options->DEFAULT_COLUMN_WIDTH = 15;
        $options->DEFAULT_ROW_HEIGHT = 25;
        $options->setColumnWidth(6, 1);
        $options->setColumnWidth(25, 2);
        $options->setColumnWidth(55, 4);
        $writer = new Writer($options);
        $writer->openToBrowser($fileName);
        $writer->getCurrentSheet()->setName('Matériels');


        $border = new Border(
            new BorderPart(Border::BOTTOM, Color::BLACK, Border::WIDTH_MEDIUM, Border::STYLE_SOLID),
            new BorderPart(Border::LEFT, Color::BLACK, Border::WIDTH_MEDIUM, Border::STYLE_SOLID),
            new BorderPart(Border::RIGHT, Color::BLACK, Border::WIDTH_MEDIUM, Border::STYLE_SOLID),
            new BorderPart(Border::TOP, Color::BLACK, Border::WIDTH_MEDIUM, Border::STYLE_SOLID)
        );

        // SELVAH
        $style = (new Style())
            ->setFontSize(48)
            ->setCellAlignment(CellAlignment::CENTER)
            ->setCellVerticalAlignment(CellVerticalAlignment::CENTER)
            ->setBorder($border);

        $options->mergeCells(0, 1, 9, 1, 0);

        $row = Row::fromValues(['SELVAH', '', '', '', '', '', '', '', '', ''], $style);
        $row->setHeight(65);
        $writer->addRow($row);

        // MATERIELS
        $style = (new Style())
            ->setFontSize(24)
            ->setCellAlignment(CellAlignment::CENTER)
            ->setCellVerticalAlignment(CellVerticalAlignment::CENTER)
            ->setBorder($border);

        $options->mergeCells(0, 2, 9, 2, 0);

        $row = Row::fromValues(['Matériels', '', '', '', '', '', '', '', '', ''], $style);
        $row->setHeight(45);
        $writer->addRow($row);

        // EN-TÊTE
        $style = (new Style())
            ->setFontBold()
            ->setFontSize(15)
            ->setShouldWrapText()
            ->setCellAlignment(CellAlignment::CENTER)
            ->setCellVerticalAlignment(CellVerticalAlignment::CENTER)
            ->setBorder($border);

        $cells = [
            Cell::fromValue('ID'),
            Cell::fromValue('Nom'),
            Cell::fromValue('Créateur'),
            Cell::fromValue('Description'),
            Cell::fromValue('Zone'),
            Cell::fromValue('Pièces détachées en stock'),
            Cell::fromValue('Nombre d\'incidents'),
            Cell::fromValue('Nombre de maintenances'),
            Cell::fromValue('Crée le'),
            Cell::fromValue('Mis à jour le')
        ];
        $row = new Row($cells, $style);
        $row->setHeight(65);
        $writer->addRow($row);

        Material::query()->whereKey($this->selectedRowsQuery->get()->pluck('id')->toArray())
        ->select(['id','user_id', 'name', 'description', 'zone_id', 'part_count', 'incident_count', 'maintenance_count', 'created_at', 'updated_at'])
        ->with(['user', 'zone'])
        ->chunk(2000, function (Collection $materials) use ($writer) {
            $border = new Border(
                new BorderPart(Border::BOTTOM, Color::BLACK, Border::WIDTH_THIN, Border::STYLE_SOLID),
                new BorderPart(Border::LEFT, Color::BLACK, Border::WIDTH_THIN, Border::STYLE_SOLID),
                new BorderPart(Border::RIGHT, Color::BLACK, Border::WIDTH_THIN, Border::STYLE_SOLID),
                new BorderPart(Border::TOP, Color::BLACK, Border::WIDTH_THIN, Border::STYLE_SOLID)
            );
            $style = (new Style())
                ->setCellAlignment(CellAlignment::LEFT)
                ->setCellVerticalAlignment(CellVerticalAlignment::CENTER)
                ->setBorder($border);

            foreach ($materials as $material) {
                    $cells = [
                        Cell::fromValue($material->id, $style),
                        Cell::fromValue($material->name, $style),
                        Cell::fromValue($material->user->username, $style),
                        Cell::fromValue($material->description, $style),
                        Cell::fromValue($material->zone->name, $style),
                        Cell::fromValue($material->part_count, $style),
                        Cell::fromValue($material->incident_count, $style),
                        Cell::fromValue($material->maintenance_count, $style),
                        Cell::fromValue(
                            $material->created_at->format('d-m-Y H:i'),
                            (new Style())->setFormat('d-m-Y H:i')
                                ->setCellAlignment(CellAlignment::LEFT)
                                ->setCellVerticalAlignment(CellVerticalAlignment::CENTER)
                                ->setBorder($border)
                        ),
                        Cell::fromValue(
                            $material->updated_at->format('d-m-Y H:i'),
                            (new Style())->setFormat('d-m-Y H:i')
                                ->setCellAlignment(CellAlignment::LEFT)
                                ->setCellVerticalAlignment(CellVerticalAlignment::CENTER)
                                ->setBorder($border)
                        )
                    ];

                    $row = new Row($cells);
                    $writer->addRow($row);
            }

            flush();
        });

        return response()->streamDownload(function () use ($writer) {
                $writer->close();
        }, $fileName);
    }
}
