<?php
namespace BDS\Exports;

use BDS\Models\Material;
use BDS\Models\Site;
use Illuminate\Database\Eloquent\Builder;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithDefaultStyles;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Exception;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Style;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class MaterialsExport implements
    FromQuery,
    WithStyles,
    WithMapping,
    WithColumnWidths,
    WithHeadings,
    WithDefaultStyles
{

    /**
     * The selected rows by their ids.
     *
     * @var array
     */
    private array $selected;

    /**
     * The field to sort by.
     *
     * @var string
     */
    private string $sortField;

    /**
     * The direction of the ordering.
     *
     * @var string
     */
    private string $sortDirection;

    /**
     * The actual site.
     *
     * @var Site
     */
    private Site $site;

    /**
     * Whatever the site is Selvah or not.
     *
     * @var bool
     */
    private bool $isSelvah;

    public function __construct(array $selected, string $sortField, string $sortDirection, Site $site)
    {
        $this->selected = $selected;
        $this->sortField = $sortField;
        $this->sortDirection = $sortDirection;
        $this->site = $site;
        $this->isSelvah = $site->id === settings('site_id_selvah');
    }

    /**
     * The query used to the rows.
     *
     * @return Builder
     */
    public function query(): Builder
    {
        return Material::query()
            ->whereKey($this->selected)
            ->with('zone', 'zone.site', 'user')
            ->orderBy($this->sortField, $this->sortDirection);
    }

    /**
     * Map the data returned to the Excel doc.
     *
     * @param Material $row
     */
    public function map($row): array
    {
        $data = [
            $row->getKey(),
            $row->name,
            $row->description,
            $row->zone->name,
            $row->user->full_name,
        ];

        if (getPermissionsTeamId() === settings('site_id_verdun_siege') && !$this->isSelvah) {
            $data[] = $row->zone->site->name;
        }

        array_push($data,
            $row->qrcode_flash_count,
            $row->incident_count,
            $row->part_count,
            $row->maintenance_count,
            $row->cleaning_count,
        );

        if ($this->isSelvah) {
            $data[] = $row->selvah_cleaning_test_ph_enabled ? 'Oui' : 'Non';
        }

        array_push($data,
            $row->cleaning_alert ? 'Oui' : 'Non',
            $row->cleaning_alert_email ? 'Oui' : 'Non',
            "Tout les  $row->cleaning_alert_frequency_repeatedly " . $row->cleaning_alert_frequency_type->label(),
            $row->last_cleaning_at?->format('d-m-Y H:i'),
            $row->last_cleaning_alert_send_at?->format('d-m-Y H:i'),
            $row->created_at->format('d-m-Y H:i'),
            $row->updated_at?->format('d-m-Y H:i')
        );

        return $data;
    }

    /**
     * Create the headings used in the Excel doc.
     *
     * @return array
     */
    public function headings(): array
    {
        $headings = [
            'ID',
            'Nom',
            'Description',
            'Zone',
            'Créateur',
            'Nb flash QR Code',
            'Nb d\'incidents',
            'Nb pièces d\'étachées',
            'Nb de maintenances',
            'Nb de nettoyages',
        ];

        if ($this->isSelvah) {
            $headings[] = 'Test PH obligatoire';
        }
        array_push(
            $headings,
            'Alerte nettoyage',
            'Alerte nettoyage Email',
            'Fréquence',
            'Dernier Nettoyage',
            'Alerte de dernier nettoyage',
            'Créé le',
            'Mis à jour le'
        );

        return [
            [strtoupper($this->site->name)],
            ['Matériels'],
            $headings
        ];
    }

    /**
     * Create the columns size used in the Excel doc.
     *
     * @return array
     */
    public function columnWidths(): array
    {
        $data = [
            'A' => 6,
            'B' => 30,
            'C' => 50,
            'D' => 20,
            'E' => 17,
            'F' => 17,
            'G' => 17,
            'H' => 17,
            'I' => 17,
            'J' => 17,
            'K' => 17,
            'L' => 17,
            'M' => 17,
            'N' => 17,
            'O' => 17,
            'P' => 17,
            'Q' => 17
        ];

        if ($this->isSelvah) {
            $data['R'] = 17;
        }

        return $data;
    }

    /**
     * Create the default style used in the whole Excel doc.
     *
     * @param Style $defaultStyle
     *
     * @return array
     */
    public function defaultStyles(Style $defaultStyle): array
    {
        return [
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_LEFT,
                'vertical' => Alignment::VERTICAL_CENTER,
                'wrapText' => true,
            ],
        ];
    }

    /**
     * Create the style for the Excel doc.
     *
     * @param Worksheet $sheet
     *
     * @return void
     *
     * @throws Exception
     */
    public function styles(Worksheet $sheet): void
    {
        $lastColumn = 'Q';

        if ($this->isSelvah) {
            $lastColumn = 'R';
        }
        // Change worksheet title
        $sheet->setTitle('Matériels');

        // SITE NAME
        $sheet->getRowDimension('1')
            ->setRowHeight(60);
        $sheet->mergeCells('A1:' . $lastColumn . '1');
        // Font
        $sheet->getStyle('A1')
            ->getFont()
            ->setSize(42);
        // Alignement
        $sheet->getStyle('A1')
            ->getAlignment()
            ->setHorizontal('center')
            ->setVertical('center');
        // Borders
        $sheet->getStyle('A1:' . $lastColumn . '1')
            ->getBorders()
            ->getAllBorders()
            ->setBorderStyle(Border::BORDER_MEDIUM);

        // FICHE NETTOYAGE
        $sheet->getRowDimension('2')
            ->setRowHeight(40);
        $sheet->mergeCells('A2:' . $lastColumn . '2');
        // Font
        $sheet->getStyle('A2')
            ->getFont()
            ->setSize(24);
        // Alignement
        $sheet->getStyle('A2')
            ->getAlignment()
            ->setHorizontal('center')
            ->setVertical('center');
        // Borders
        $sheet->getStyle('A2:' . $lastColumn . '2')
            ->getBorders()
            ->getAllBorders()
            ->setBorderStyle(Border::BORDER_MEDIUM);

        // EN-TETE
        $sheet->getRowDimension('3')
            ->setRowHeight(50);
        // Font
        $sheet->getStyle('A3:' . $lastColumn . '3')
            ->getFont()
            ->setSize(12)
            ->setBold(true);
        // Alignement
        $sheet->getStyle('A3:' . $lastColumn . '3')
            ->getAlignment()
            ->setHorizontal('center')
            ->setVertical('center');
        // Borders
        $sheet->getStyle('A3:' . $lastColumn . '3')
            ->getBorders()
            ->getAllBorders()
            ->setBorderStyle(Border::BORDER_MEDIUM);

        // ROWS
        for ($i = 4; $i <= count($this->selected) + 3; $i++) {
            $sheet->getStyle('A' . $i . ':' . $lastColumn . $i)
                ->getBorders()
                ->getAllBorders()
                ->setBorderStyle(Border::BORDER_THIN);
        }
    }
}
