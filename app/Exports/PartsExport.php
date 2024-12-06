<?php
namespace BDS\Exports;

use BDS\Models\Part;
use BDS\Models\Site;
use Illuminate\Database\Eloquent\Builder;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithCustomValueBinder;
use Maatwebsite\Excel\Concerns\WithDefaultStyles;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Cell\Cell;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use PhpOffice\PhpSpreadsheet\Cell\DefaultValueBinder;
use PhpOffice\PhpSpreadsheet\Exception;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Style;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class PartsExport extends DefaultValueBinder implements
    FromQuery,
    WithStyles,
    WithMapping,
    WithColumnWidths,
    WithHeadings,
    WithDefaultStyles,
    WithCustomValueBinder
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
        return Part::query()
            ->whereKey($this->selected)
            ->with(['materials', 'user', 'site', 'supplier', 'editedUser'])
            ->orderBy($this->sortField, $this->sortDirection);
    }

    /**
     * Map the data returned to the Excel doc.
     *
     * @param Part $row
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
            $row->name,
            $row->description
        );

        $materials = '';

        foreach ($row->materials as $material) {
            $materials .= $material->name . PHP_EOL;
        }

        array_push($data,
            $materials,
            $row->user->full_name,
            $row->reference,
            $row->supplier->name,
            $row->price,
            (string)$row->stock_total,
            $row->stock_total * $row->price,
            $row->number_warning_enabled ? 'Oui' : 'Non',
            $row->number_warning_minimum,
            $row->number_critical_enabled ? 'Oui' : 'Non',
            $row->number_critical_minimum,
            (string)$row->part_entry_total,
            (string)$row->part_exit_total,
            (string)$row->part_entry_count,
            (string)$row->part_exit_count,
            (string)$row->material_count,
            (string)$row->qrcode_flash_count,
            (string)$row->edit_count,
            $row->is_edited ? 'Oui' : 'Non',
            $row->editedUser?->full_name,
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
            'ID'
        ];

        if (getPermissionsTeamId() === settings('site_id_verdun_siege')) {
            $headings[] = 'Site';
        }

        array_push(
            $headings,
            'Nom',
            'Description',
            'Matériels',
            'Créateur',
            'Référence',
            'Fournisseur',
            'Prix Unité (€)',
            'Nb en stock',
            'Prix des pièces en stock ( €)',
            'Alerte activée',
            'Qt minimum pour l\'alerte',
            'Alerte critique activée',
            'Qt minimum pour l\'alerte critique',
            'Nb total de pièce entrée',
            'Nb total de pièce sortie',
            'Nb total d\'entrée',
            'Nb total de sortie',
            'Nb matériels',
            'Nb flash QrCode',
            'Nb d\'édition',
            'Est éditée',
            'Edité par',
            'Créé le',
            'Mis à jour le'
        );

        return [
            [strtoupper($this->site->name)],
            ['Pièces Détachées'],
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
            'D' => 30,
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
            'Q' => 17,
            'R' => 17,
            'S' => 17,
            'T' => 17,
            'U' => 17,
            'V' => 17,
            'W' => 17,
            'X' => 17,
            'Y' => 17
        ];

        if (getPermissionsTeamId() === settings('site_id_verdun_siege')) {
            $data['Z'] = 17;
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
        $lastColumn = 'Y';

        if (getPermissionsTeamId() === settings('site_id_verdun_siege')) {
            $lastColumn = 'Z';
        }
        // Change worksheet title
        $sheet->setTitle('Pièces Détachées');

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

        // FICHE PIECES DETACHEES
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

    /**
     * @throws Exception
     */
    public function bindValue(Cell $cell, $value): bool
    {
        if (is_numeric($value)) {
            $cell->setValueExplicit(
                $value,
                DataType::TYPE_NUMERIC
            );

            return true;
        }

        // else return default behavior
        return parent::bindValue($cell, $value);
    }
}
