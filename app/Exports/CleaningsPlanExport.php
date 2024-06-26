<?php
namespace BDS\Exports;

use BDS\Models\Cleaning;
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

class CleaningsPlanExport implements
    FromQuery,
    WithStyles,
    WithMapping,
    WithColumnWidths,
    WithHeadings,
    WithDefaultStyles
{
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

    public function __construct(Site $site)
    {
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
            ->select([
                'id',
                'name',
                'description',
                'zone_id',
                'selvah_cleaning_test_ph_enabled',
                'cleaning_alert',
                'cleaning_alert_email',
                'cleaning_alert_frequency_repeatedly',
                'cleaning_alert_frequency_type',
                'last_cleaning_at',
                'last_cleaning_alert_send_at'
            ])
            ->whereRelation('zone.site', 'id', $this->site->id)
            ->where('cleaning_alert', '=', true)
            ->with(['zone'])
            ->orderBy('cleaning_alert_frequency_type')
            ->orderBy('cleaning_alert_frequency_repeatedly');
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
            "Tout les  $row->cleaning_alert_frequency_repeatedly " . $row->cleaning_alert_frequency_type->label(),
            $row->cleaning_alert_email ? 'Oui' : 'Non',

        ];

        if ($this->isSelvah) {
            $data[] = $row->selvah_cleaning_test_ph_enabled ? 'Oui' : 'Non';
        }

        array_push($data,
            $row->last_cleaning_at?->format('d-m-Y H:i'),
            $row->last_cleaning_alert_send_at?->format('d-m-Y H:i')
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
            'Nom du Matériel',
            'Description',
            'Zone',
            'Fréquence de Nettoyage',
            'Alerte par Email'
        ];

        if ($this->isSelvah) {
            $headings[] = 'Test PH obligatoire';
        }
        array_push($headings, 'Dernier Nettoyage', 'Alerte de dernier nettoyage');

        return [
            [strtoupper($this->site->name)],
            ['Plan de Nettoyage'],
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
            'C' => 60,
            'D' => 20,
            'E' => 20,
            'F' => 17,
            'G' => 17,
            'H' => 17,
        ];

        if ($this->isSelvah) {
            $data['I'] = 17;
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
        $lastColumn = 'H';

        if ($this->isSelvah) {
            $lastColumn = 'I';
        }

        // Change worksheet title
        $sheet->setTitle('Plan de Nettoyage');

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
        for ($i = 4; $i <= $this->query()->get()->count() + 3; $i++) {
            $sheet->getStyle('A' . $i . ':' . $lastColumn . $i)
                ->getBorders()
                ->getAllBorders()
                ->setBorderStyle(Border::BORDER_THIN);
        }
    }
}
