<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;

class LegajosCBExport implements FromCollection, WithHeadings, WithStyles, ShouldAutoSize
{
    protected $legajos;

    public function __construct($legajos)
    {
        $this->legajos = $legajos;
    }

    public function collection()
    {
        return $this->legajos->map(function ($legajo) {
            return [
                'id' => $legajo->id,
                'fecha_inscripcion' => $legajo->fecha_inscripcion,
                'fecha_inicio' => $legajo->fecha_inicio,
                'sede' => $legajo->sede->description ?? '',
                'tipo_legajo' => $legajo->tipo_legajo->description ?? '',
                'estado' => $legajo->estadocbj->description ?? '',
                'titular_nombre' => $legajo->person->name ?? '',
                'titular_apellido' => $legajo->person->lastname ?? '',
                'titular_documento' => $legajo->person->num_documento ?? '',
                'titular_fecha_nac' => $legajo->person->fecha_nac ?? '',
                'titular_genero' => $legajo->person->genero ?? '',
                'responsable_nombre' => $legajo->responsable->name ?? '',
                'responsable_apellido' => $legajo->responsable->lastname ?? '',
                'responsable_documento' => $legajo->responsable->num_documento ?? '',
                'parentesco' => $legajo->parentesco->description ?? '',
                'phone_emergency' => $legajo->phone_emergency,
                'apoyo_escolar' => $legajo->autorizacion && $legajo->autorizacion->apoyo_escolar ? 'Sí' : 'No',
                'actividad_empleo' => $legajo->autorizacion && $legajo->autorizacion->actividad_empleo ? 'Sí' : 'No',
                'autorizacion_firmada' => $legajo->autorizacion && $legajo->autorizacion->autorizacion_firmada ? 'Sí' : 'No',
                'autorizacion_retirarse' => $legajo->autorizacion && $legajo->autorizacion->autorizacion_retirarse ? 'Sí' : 'No',
                'autorizacion_uso_imagen' => $legajo->autorizacion && $legajo->autorizacion->autorizacion_uso_imagen ? 'Sí' : 'No',
                'observacion' => $legajo->observacion,
            ];
        });
    }

    public function headings(): array
    {
        return [
            'ID Legajo',
            'Fecha Inscripción',
            'Fecha Inicio',
            'Sede',
            'Tipo Legajo',
            'Estado',
            'Titular - Nombre',
            'Titular - Apellido',
            'Titular - Documento',
            'Titular - Fecha Nacimiento',
            'Titular - Género',
            'Responsable - Nombre',
            'Responsable - Apellido',
            'Responsable - Documento',
            'Parentesco',
            'Teléfono Emergencia',
            'Apoyo Escolar',
            'Actividad Empleo',
            'Autorización Firmada',
            'Autorización Retirarse',
            'Autorización Uso Imagen',
            'Observación'
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $lastColumn = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex(count($this->headings()));
        $headerRange = "A1:{$lastColumn}1";

        // Estilo para los encabezados
        $sheet->getStyle($headerRange)->applyFromArray([
            'font' => [
                'bold' => true,
                'size' => 12,
                'color' => ['rgb' => 'FFFFFF']
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => [
                    'rgb' => '4CAF50'
                ]
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['rgb' => '000000'],
                ],
            ]
        ]);

        // Estilo para todas las celdas con datos
        $sheet->getStyle("A1:{$lastColumn}" . $sheet->getHighestRow())->applyFromArray([
            'alignment' => [
                'wrapText' => true,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['rgb' => 'CCCCCC'],
                ],
            ]
        ]);

        return [];
    }
}
