<?php

namespace App\Exports;

use App\Models\Manager\Escuela;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithTitle;

class EscuelasExport implements FromCollection, WithHeadings, WithStyles, ShouldAutoSize, WithColumnFormatting, WithTitle, WithCustomStartCell
{
    use Exportable;

    protected $dependencia_id;

    public function __construct($dependencia_id = null)
    {
        $this->dependencia_id = $dependencia_id;
    }

    public function collection()
    {
        $query = Escuela::select(
            'id',
            'description',
            'infante',
            'primaria',
            'secundaria',
            'nocturna',
            'activo',
            'created_at',
            'updated_at'
        );

        if ($this->dependencia_id) {
            $query->where('dependencia_id', $this->dependencia_id);
        }

        return $query->get()->map(function ($escuela) {
            return [
                'ID' => $escuela->id,
                'Descripción' => $escuela->description,
                'Jardín Infantes' => $escuela->infante ? 'Sí' : 'No',
                'Primaria' => $escuela->primaria ? 'Sí' : 'No',
                'Secundaria' => $escuela->secundaria ? 'Sí' : 'No',
                'Nocturna' => $escuela->nocturna ? 'Sí' : 'No',
                'Activo' => $escuela->activo ? 'Sí' : 'No',
                'Fecha Creación' => $escuela->created_at ? $escuela->created_at->format('d-m-Y H:i:s') : '',
                'Fecha Actualización' => $escuela->updated_at ? $escuela->updated_at->format('d-m-Y H:i:s') : '',
            ];
        });
    }

    public function startCell(): string
    {
        return 'A1';
    }

    public function title(): string
    {
        return 'Escuelas';
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle('A1:' . $sheet->getHighestColumn() . '1')
            ->applyFromArray([
                'font' => [
                    'bold' => true,
                    'size' => 14,
                ],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => [
                        'rgb' => 'CCCCCC',
                    ]
                ],
            ]);

        $sheet->getRowDimension(1)->setRowHeight(30);
    }

    public function headings(): array
    {
        return [
            'ID',
            'Descripción',
            'Jardín Infantes',
            'Primaria',
            'Secundaria',
            'Nocturna',
            'Activo',
            'Fecha Creación',
            'Fecha Actualización'
        ];
    }

    public function columnFormats(): array
    {
        return [];
    }
}
