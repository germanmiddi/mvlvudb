<?php

namespace App\Exports\Cajas;

use App\Models\Manager\Entrevista;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;


class TemplateEntrevistasExport2 implements FromArray, WithStyles, ShouldAutoSize
{
    protected $puntosEntrega;
    protected $entrevistadores;
    protected $tipoDocumento;
    protected $situacionConyugal;
    public function __construct($puntosEntrega, $entrevistadores, $tipoDocumento, $situacionConyugal)
    {
        $this->puntosEntrega = $puntosEntrega;
        $this->entrevistadores = $entrevistadores;
        $this->tipoDocumento = $tipoDocumento;
        $this->situacionConyugal = $situacionConyugal;
    }

    public function array(): array
    {
        // Calcular el número máximo de filas para las columnas
        $maxRows = max(count($this->puntosEntrega), count($this->situacionConyugal));

        // Asegurarnos de que todas las columnas tengan el mismo número de filas, rellenando con valores vacíos si es necesario
        $puntosEntrega = array_pad($this->puntosEntrega->toArray(), $maxRows, '');
        $entrevistadores = array_pad($this->entrevistadores->toArray(), $maxRows, '');
        $tipoDocumento = array_pad($this->tipoDocumento->toArray(), $maxRows, '');
        $situacionConyugal = array_pad($this->situacionConyugal->toArray(), $maxRows, '');

        // Organizar los datos en un arreglo para la hoja 2
        $data = [];

        $data[] = ['Sedes', '', 'Entrevistador', '', 'Tipo Documento', '', 'Situación Conyugal'];

        // Agregar las filas con los valores
        for ($i = 0; $i < $maxRows; $i++) {
            $data[] = [
                $puntosEntrega[$i],
                '',
                $entrevistadores[$i],
                '',
                $tipoDocumento[$i],
                '',
                $situacionConyugal[$i]

            ];
        }

        return $data;
    }
    // Método para autoajustar las columnas al contenido
    public function autoSize(): array
    {
        return [
            'A',
            'B',
            'C',
            'D',
            'E',
            'F',
            'G', // Ajustar el tamaño de las columnas A-G
        ];
    }

    // Método para aplicar estilos a las celdas
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

