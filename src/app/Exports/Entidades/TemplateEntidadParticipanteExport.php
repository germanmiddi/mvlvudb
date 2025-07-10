<?php

namespace App\Exports\Entidades;


use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
class TemplateEntidadParticipanteExport implements FromArray, WithStyles, ShouldAutoSize
{
    public function array(): array
    {
        return [
            [
                'id_entidad',
                'rol_id',
                'numero_entidad',
                'nombre_entidad',
                'nombre',
                'apellido',
                'num_documento',
                'telefono',
                'email',
                'fecha_nacimiento',
            ]
        ];
    }
    public function styles(Worksheet $sheet)
    {
        // Estilo para la primera y segunda fila
        return [
            1 => [
                'font' => ['bold' => true],  // Poner el texto en negrita
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['argb' => 'CCCCCC'], // Fondo gris
                ],
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                ]
            ]
        ];
    }
}

