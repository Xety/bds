<?php
namespace BDS\Exports;

use BDS\Models\Cleaning;
use BDS\Models\Site;
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

class CleaningsExport implements
    FromQuery,
    WithStyles,
    WithMapping,
    WithColumnWidths,
    WithHeadings,
    WithDefaultStyles
{

    private array $selected;
    private string $sortField;
    private string $sortDirection;
    private Site $site;
    private bool $isSelvah;

    public function __construct(array $selected, string $sortField, string $sortDirection, Site $site)
    {
        $this->selected = $selected;
        $this->sortField = $sortField;
        $this->sortDirection = $sortDirection;
        $this->site = $site;
        $this->isSelvah = $site->id === settings('site_id_selvah');
    }

    public function query()
    {
        return Cleaning::query()
            ->whereKey($this->selected)
            ->select(['id', 'material_id', 'user_id', 'description', 'selvah_ph_test_water', 'selvah_ph_test_water_after_cleaning', 'type', 'created_at'])
            ->with(['site', 'user', 'material', 'material.zone'])
            ->orderBy($this->sortField, $this->sortDirection);
    }

    /**
     * @param Cleaning $row
     */
    public function map($row): array
    {
        $data = [
            $row->getKey(),
            $row->material->name,
            $row->material->zone->name,
            $row->description,
            $row->user->full_name,
        ];

        if ($this->isSelvah) {
            array_push($data,
                $row->selvah_ph_test_water,
                $row->selvah_ph_test_water_after_cleaning);
        }

        array_push($data,
            $row->type->label(),
            $row->created_at->format('d-m-Y H:i')
        );

        return $data;
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        $headings = [
            'ID',
            'Matériel',
            'Zone',
            'Description',
            'Créateur'
        ];

        if ($this->isSelvah) {
            array_push($headings, 'Test PH de l\'eau', 'Test PH de l\'eau après nettoyage');
        }
        array_push($headings, 'Fréquence', 'Créé le');

        return [
            [strtoupper($this->site->name)],
            ['Fiche de Nettoyage'],
            $headings
        ];
    }

    /**
     * @return array
     */
    public function columnWidths(): array
    {
        $data = [
            'A' => 6,
            'B' => 30,
            'C' => 20,
            'D' => 60,
            'E' => 20,
            'F' => 17,
            'G' => 17
        ];

        if ($this->isSelvah) {
            $data['H'] = 17;
            $data['I'] = 17;
        }

        return $data;
    }

    /**
     * @param Style $defaultStyle
     * @return array[]
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
     *
     * @param Worksheet $sheet
     * @return void
     *
     * @throws Exception
     */
    public function styles(Worksheet $sheet): void
    {
        $lastColumn = 'G';
        if ($this->isSelvah) {
            $lastColumn = 'I';
        }
        // Change worksheet title
        $sheet->setTitle('Nettoyages');

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
