<?php

namespace App\Exports\Cajas;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;

use Maatwebsite\Excel\Concerns\WithTitle;

class EntregasExport implements WithStyles, FromView, ShouldAutoSize
{

    use Exportable;
    /**
     * @return \Illuminate\Support\Collection
     */

    protected $values;
    protected $data;
    protected $headings;
    protected $titles;
    protected $persons;
    protected $collections;
    protected $localidades;
    protected $barrios;

    function __construct($values, $titles, $persons, $collections, $localidades, $barrios)
    {
        $this->values = $values;
        $this->titles = $titles;
        $this->persons = $persons;
        $this->collections = $collections;
        $this->localidades = $localidades;
        $this->barrios = $barrios;
    }

    public function view(): view
    {
        $values = $this->values;
        $titles = $this->titles;
        $persons = $this->persons;
        $collections = $this->collections;
        $localidades = $this->localidades;
        $barrios = $this->barrios;
        $data = [];

        foreach ($collections as $collection) {

            $direccion = $collection->address;

            // Extraer localidad y barrio dekl string que llega de la bd
            preg_match('/localidad:(\d+)/', $direccion, $localidadMatches);
            preg_match('/barrio:(\d+)/', $direccion, $barrioMatches);

            $localidadId = $localidadMatches[1] ?? null;
            $barrioId = $barrioMatches[1] ?? null;

            $localidadNombre = $localidades->where('id', $localidadId)->value('description') ?? '';
            $barrioNombre = $barrios->where('id', $barrioId)->value('description') ?? '';

            preg_match('/calle:([^num:]+)/', $direccion, $calleMatches);
            preg_match('/num:(\d+)/', $direccion, $numeroMatches);

            $calle = $calleMatches[1] ?? '';
            $numero = $numeroMatches[1] ?? '';
            $direccionFormateada = "Calle $calle N° $numero, Localidad: $localidadNombre, Barrio: $barrioNombre";

            $data[] = [
                'Persona' => optional($collection->person)->name . ' ' . optional($collection->person)->lastname,
                'DNI' => optional($collection->person)->num_documento,
                'Dirección' => $direccionFormateada,
                'Fecha' => $collection->date,
                'Punto de Entrega' => optional($collection->puntoEntrega)->description,
                'Producto' => optional($collection->product)->name,
                'Entregado Por' => optional($collection->user)->name,
            ];
        }

        return view('exports.inscriptos', [
            'data' => $data,
            'titles' => $titles,
        ]);
    }

    // Define el inicio del archivo.
    public function startCell(): string
    {
        return 'A1';
    }

    // Titulo de la hoja de excel.
    public function title(): string
    {
        return 'Detalle de Entregas';
    }

    public function styles(Worksheet $sheet)
    {
        $lastColumn = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex(count($this->titles));
        $headerRange = "A1:{$lastColumn}1";

        $sheet->getStyle($headerRange)->applyFromArray([
            'font' => [
                'bold' => true,
                'size' => 14,
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
                'justify' => Alignment::HORIZONTAL_JUSTIFY,
            ],
            'borders' => [
                'outline' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['rgb' => '000000'],
                ],
            ]
        ]);

        $sheet->getStyle("A1:{$lastColumn}" . $sheet->getHighestRow())->applyFromArray([
            'alignment' => [
                'wrapText' => true,
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ]
        ]);


        return [];
    }

    //Define el ancho de las columnas, si esta vacio se autoajustan

    public function cacheFor()
    {
        // Define el tiempo en minutos durante el cual la caché debe ser válida
        return now()->addMinutes(60); // 60 minutos de caché
    }



}
