<?php
namespace BDS\Exports;

use BDS\Models\Incident;
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

class IncidentsExport implements
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
        return Incident::query()
            ->whereKey($this->selected)
            ->with('material', 'user', 'site', 'material.zone')
            ->orderBy($this->sortField, $this->sortDirection);
    }

    /**
     * Map the data returned to the Excel doc.
     *
     * @param Incident $row
     */
    public function map($row): array
    {
        $data = [
            $row->getKey()
        ];

        if (getPermissionsTeamId() === settings('site_id_verdun_siege')) {
            $data[] = $row->site->name;
        }

        array_push($data,
            $row->maintenance ? $row->maintenance->getKey() : '',
            $row->material->name,
            $row->material->zone->name,
            $row->user->full_name,
            $row->description,
            $row->impact->label(),
            $row->started_at->format('d-m-Y H:i'),
            $row->finished_at ? 'Oui' :  'Non',
            $row->finished_at?->format('d-m-Y H:i')
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
            'ID'
        ];

        if (getPermissionsTeamId() === settings('site_id_verdun_siege')) {
            $headings[] = 'Site';
        }

        array_push(
            $headings,
            'Maintenance n°',
            'Matériel',
            'Zone',
            'Créateur',
            'Description',
            'Impact',
            'Créé le',
            'Résolu',
            'Résolu le'
        );

        return [
            [strtoupper($this->site->name)],
            ['Incidents'],
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
            'C' => 20,
            'D' => 17,
            'E' => 17,
            'F' => 17,
            'G' => 17,
            'H' => 17,
            'I' => 17,
            'J' => 17,
        ];

        if (getPermissionsTeamId() === settings('site_id_verdun_siege')) {
            $data['K'] = 17;
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
        $lastColumn = 'J';

        if (getPermissionsTeamId() === settings('site_id_verdun_siege')) {
            $lastColumn = 'K';
        }
        // Change worksheet title
        $sheet->setTitle('Incidents');

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
