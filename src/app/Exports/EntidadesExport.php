<?php

namespace App\Exports;

use App\Models\Manager\Entidad;
use App\Models\Manager\Tramite;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
//use Maatwebsite\Excel\Concerns\WithCache;

use Maatwebsite\Excel\Concerns\WithTitle;

class EntidadesExport implements FromCollection, WithHeadings, WithStyles, ShouldAutoSize, WithColumnFormatting, WithTitle, WithCustomStartCell
{

    use Exportable;
    /**
    * @return \Illuminate\Support\Collection
    */

    protected $data;

    function __construct($param) {
        $this->data = $param;
    }

    public function collection()
    {
        
        $result = Entidad::query();

        $result->select('entidades.id', 
                'entidades.num_entidad', 
                'entidades.name',
                'entidades.objeto',
                'entidades.address',
                'localidades.description',
                'entidades.phone',
                'entidades.email',
                'entidades.solicitud_inscripcion',
                'entidades.personeria',
                'entidades.eximision',
                'entidades.observation',
                DB::raw("DATE_FORMAT(entidades.fecha_inscripcion, '%d-%m-%Y')" ),
                DB::raw("DATE_FORMAT(entidades.fecha_fundacion, '%d-%m-%Y')" ),
                DB::raw("DATE_FORMAT(entidades.fecha_fin_mandato, '%d-%m-%Y')" ),
                DB::raw("DATE_FORMAT(entidades.fecha_memoria, '%d-%m-%Y')" ),
                DB::raw("DATE_FORMAT(entidades.fecha_asamblea, '%d-%m-%Y')" ),
                'tipos_entidades.description',
                'tipos_actividades.description'
                /* DB::raw("DATE_FORMAT(tramites.fecha, '%d-%m-%Y')" ),*/
                )

                ->leftjoin('localidades', 'localidades.id', '=', 'entidades.localidad_id')
                ->leftjoin('tipos_actividades', 'tipos_actividades.id', '=', 'entidades.tipo_actividad_id')
                ->leftjoin('tipos_entidades', 'tipos_entidades.id', '=', 'entidades.tipo_entidad_id')
;

        if(isset($this->data['name'])){
            $result->where('entidades.name', 'LIKE', '%'.$this->data['name'].'%');
        }

        if(isset($this->data['num_entidad'])){
            $result->where('entidades.num_entidad', 'LIKE', '%'.$this->data['num_entidad'].'%');
        }

        if(isset($this->data['tipo_entidad_id'])){
            $result->where('entidades.tipo_entidad_id', $this->data['tipo_entidad_id']);
        }

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
                'ID',
                'N° Entidad',
                'Nombre',
                'Objeto',
                'Direccion',
                'Localidad',
                'Telefono',
                'Email',
                'Solicitud Inscripcion',
                'Personeria',
                'Eximision',
                'Observacion',
                'Fecha Inscripcion',
                'Fecha Fundacion',
                'Fecha Fin de Mandato',
                'Fecha Memoria',
                'Fecha Asamblea',
                'Tipo Entidad',
                'Tipo Actividad'
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
