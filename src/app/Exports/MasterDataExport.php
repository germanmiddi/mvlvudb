<?php

namespace App\Exports;

use App\Models\Manager\TipoEntidad;
use App\Models\Manager\TipoTramite;
use App\Models\Manager\Tramite;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
//use Maatwebsite\Excel\Concerns\WithCache;

use Maatwebsite\Excel\Concerns\WithTitle;

class MasterDataExport implements WithMultipleSheets //FromCollection, WithHeadings, WithStyles, ShouldAutoSize, WithColumnFormatting, WithTitle, WithCustomStartCell
{

    use Exportable;
    /**
    * @return \Illuminate\Support\Collection
    */

    //protected $data;


    function __construct() {
        //$this->data = $param;
    }

    public function sheets(): array
    {
        $sheets = [];
        $param = [];

        $param['titles'] = ['Tipo Tramite','Paises','Barrios', 'Localidades', 
            'Canales Atencion', 'Cobertura Medica', 'Estado Educativo'];

        for ($id = 0; $id < count($param['titles']); $id++) {
            // Canal de Atencion
            $param['id'] = $id;
            $sheets[$id] = new MasterExport($param);

            // Tipo Tramite
           /*  $param['id'] = 1;
            $sheets[1] = new MasterExport($param);
            $param['id'] = 2;
            $sheets[2] = new MasterExport($param);
            $param['id'] = 3;
            $sheets[3] = new MasterExport($param); */

        }

        return $sheets;
    }


    public function collection()
    {
        
        $result = Tramite::query();

        return $result->get();
    }

    // Define el inicio del archivo.
    public function startCell(): string
    {
        return 'A1';
    }

    // Titulo de la hoja de excel.
    public function title(): string
    {
        return 'Detalle Tramites';
    }

    public function styles(Worksheet $sheet)
    {
        // Aplica un estilo a las celdas de la cabecera
        $sheet->getStyle('A1:' . $sheet->getHighestColumn() . '1')
        ->applyFromArray([
            'font' => [
                'bold' => true,
                'size' => 14,
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => [
                    'rgb' => 'CCCCCC', // Corregido el color de fondo GRIS
                ]
            ],
        ]);

        $sheet->getRowDimension(1)->setRowHeight(30);
    }

    // encabezados
    public function headings(): array
    {
        return [
                'Nombre',
                'Apellido',
                'Num. Documento',
                'Fecha Nacimiento',
                'Localidad',
                'Escuela',
                'Estado Educativo',
                'Ocupación',
                'Fecha Tramite',
                'Tipo Tramite',
                'Dependencia',
                'Barrio',
                //'Nomenclatura', //No se utiliza
                'Observacion'
        ];
    }

    //Define el ancho de las columnas, si esta vacio se autoajustan
    public function columnFormats(): array
    {
        return [   
                
        ];
    }

    public function cacheFor()
    {
        // Define el tiempo en minutos durante el cual la caché debe ser válida
        return now()->addMinutes(60); // 60 minutos de caché
    }


    
}
