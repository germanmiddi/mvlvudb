<?php

namespace App\Exports\Cajas;

use App\Models\Manager\Entrevista;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
class TemplateEntrevistasHeaderExport implements FromArray, WithStyles, ShouldAutoSize
{
    public function array(): array
    {
        return [
            [
                'FECHA',
                'SEDE',
                'ENTREVISTADOR',
                'ESTADO',
                'TIPO_DOCUMENTO',
                'NUM_DOCUMENTO',
                'APELLIDO',
                'NOMBRE',
                'FECHA_NACIMIENTO',
                'CANT_HIJOS',
                'CANT_CONVIVIENTES',
                'TENENCIA',
                'PAGO_INQUILINO',
                'AMBIENTES',
                'OCUPACION',
                'COBERTURA_SALUD',
                'RECIBE_PENSION',
                'PROGRAMA_SOCIAL',
                'NIVEL_EDUCATIVO',
                'NIVEL_EDUCATIVO_ALCANZADO'
            ]
        ];
    }
    public function styles(Worksheet $sheet)
    {
        // Estilo para la primera fila (celdas de título)
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
            ],
        ];
    }
}

