<?php
namespace BDS\Exports;

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

class SitesExport implements
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

    public function __construct(array $selected, string $sortField, string $sortDirection, Site $site)
    {
        $this->selected = $selected;
        $this->sortField = $sortField;
        $this->sortDirection = $sortDirection;
        $this->site = $site;
    }

    /**
     * The query used to the rows.
     *
     * @return Builder
     */
    public function query(): Builder
    {
        return Site::query()
            ->whereKey($this->selected)
            ->with('managers')
            ->orderBy($this->sortField, $this->sortDirection);
    }

    /**
     * Map the data returned to the Excel doc.
     *
     * @param Site $row
     */
    public function map($row): array
    {
        $data = [
            $row->getKey(),
            $row->name
        ];

        $managers = '';
        foreach ($row->managers as $manager) {
            $managers .= $manager->full_name . PHP_EOL;
        }

        array_push($data,
            $managers,
            $row->zone_count,
            $row->email,
            $row->office_phone,
            $row->cell_phone,
            $row->address,
            $row->zip_code,
            $row->city,
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
            'Responsables',
            'Nb de Zone',
            'Email',
            'Tel bureau',
            'Tel portable',
            'Adresse',
            'Code Postal',
            'Ville',
            'Créé le',
            'Mis à jour le'
        ];

        return [
            [strtoupper($this->site->name)],
            ['Sites'],
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
            'B' => 17,
            'C' => 17,
            'D' => 17,
            'E' => 25,
            'F' => 17,
            'G' => 17,
            'H' => 25,
            'I' => 17,
            'J' => 20,
            'K' => 17,
            'L' => 17,
        ];

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
        $lastColumn = 'L';

        // Change worksheet title
        $sheet->setTitle('Sites');

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

        // FICHE FOURNISSEURS
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
