<?php

namespace App\Exports;

use App\Models\Manager\Person;
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

class PersonsExport implements FromCollection, WithHeadings, WithStyles, ShouldAutoSize, WithColumnFormatting, WithTitle, WithCustomStartCell
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
        
        $result = Person::query();

        $result->select('person.name', 
                'person.lastname', 
                'person.num_documento',
                DB::raw("DATE_FORMAT(person.fecha_nac, '%d-%m-%Y')"),
                'contact_data.phone as phone',
                'contact_data.celular as celular',
                'contact_data.email as email',
                'paises.description as pais',
                'localidades.description as localidad',
                'barrios.description as barrio',
                'address_data.calle as calle',
                'address_data.number as numero',
                'address_data.piso as piso',
                'address_data.dpto as dpto',
                'address_data.google_address as google_address',

                'aditional_data.cant_hijos as cant_hijos',
                'situacion_conyugal.description as conyugal',
                'cud.codigo as codigo',
                'cud.diagnostico as diagnostico',
                'tipo_ocupacion.description as tipo_ocupacion',
                'cobertura_medica.description as cobertura_medica',
                'tipo_pension.description as tipo_pension',
                'programa_social.description as programa_social'
                )
                
                ->leftjoin('contact_data', 'contact_data.person_id', '=', 'person.id')
                ->leftjoin('cud', 'cud.person_id', '=', 'person.id')
                ->leftjoin('address_data', 'address_data.person_id', '=', 'person.id')
                ->leftjoin('aditional_data', 'aditional_data.person_id', '=', 'person.id')
                ->leftjoin('education_data','education_data.person_id','=', 'person.id')
                ->leftjoin('paises', 'paises.id', '=', 'address_data.pais_id')
                ->leftjoin('localidades', 'localidades.id', '=', 'address_data.localidad_id')
                ->leftjoin('barrios', 'barrios.id', '=', 'address_data.barrio_id')
                ->leftjoin('situacion_conyugal', 'situacion_conyugal.id', '=', 'aditional_data.situacion_conyugal_id')
                ->leftjoin('social_data', 'social_data.person_id', '=', 'person.id')
                ->leftjoin('tipo_ocupacion', 'tipo_ocupacion.id', '=', 'social_data.tipo_ocupacion_id')
                ->leftjoin('cobertura_medica', 'cobertura_medica.id', '=', 'social_data.cobertura_medica_id')
                ->leftjoin('tipo_pension', 'tipo_pension.id', '=', 'social_data.tipo_pension_id')
                ->leftjoin('programa_social', 'programa_social.id', '=', 'social_data.programa_social_id')

           /*  ->join('person_tramite', 'person_tramite.tramite_id', '=', 'tramites.id')
            ->join('person', 'person.id', '=', 'person_tramite.person_id')
            ->leftjoin('education_data','education_data.person_id','=', 'person.id')
            ->leftjoin('address_data', 'address_data.person_id', '=', 'person.id')
            ->leftjoin('social_data', 'social_data.person_id', '=', 'person.id')
            ->leftjoin('escuelas', 'escuelas.id', '=', 'education_data.escuela_id')
            ->leftjoin('estado_educativo', 'estado_educativo.id', '=', 'education_data.estado_educativo_id')
            ->leftjoin('tipo_ocupacion', 'tipo_ocupacion.id', '=', 'social_data.tipo_ocupacion_id')
            ->leftjoin('tipo_tramite', 'tipo_tramite.id', '=', 'tramites.tipo_tramite_id')
            ->leftjoin('dependencias', 'dependencias.id', '=', 'tramites.dependencia_id')
            ->where('person_tramite.rol_tramite_id', '1') */;

       /*  if(isset($this->data['dependencia_id'])){
            $result->where('tramites.dependencia_id', $this->data['dependencia_id']);
        }

        if(isset($this->data['tipo_tramite_id'])){
            $result->where('tramites.tipo_tramite_id', $this->data['tipo_tramite_id']);
        }

        if(isset($this->data['from']) && isset($this->data['to'])){
            $result->where('fecha','>=', $this->data['from'])
                    ->where('fecha', '<', $this->data['to']);
        }

        if(isset($this->data['estado_id'])){
            $estado_id = json_decode($this->data['estado_id']);
            $result->where('estado_id', $estado_id);
        }

        if(isset($this->data['asigned_me'])){
            $result->where('assigned', Auth::user()->id);
        } */

        if(isset($this->data['lastname'])){
            $lastname = $this->data['lastname'];  
            $result->where('person.lastname', 'LIKE', '%'.$lastname.'%');
        }

        if(isset($this->data['name'])){
            $name = $this->data['name'];  
            $result->where('person.name', 'LIKE', '%'.$name.'%');
        }

        if(isset($this->data['num_documento'])){
            $num_documento = $this->data['num_documento'];  
            $result->where('person.num_documento', 'LIKE', '%'.$num_documento.'%');
        }

        if(isset($this->data['localidad'])){
            $localidad = $this->data['localidad'];  
            $result->where('address_data.localidad_id', $localidad);
        }

        if(isset($this->data['barrio'])){
            $barrio = $this->data['barrio'];  
            $result->where('address_data.barrio_id', $barrio);
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
                'Nombre',
                'Apellido',
                'Num. Documento',
                'Fecha Nacimiento',
                'Telefono',
                'Celular',
                'Email',
                'Pais',
                'Localidad',
                'Barrio',
                'Calle',
                'Numero',
                'Piso',
                'Dpto',
                'Google Address',
                'Cant Hijos',
                'Situacion Conyugal',
                'Codigo CUD',
                'Diagnostico CUD',
                'Tipo Ocupacion',
                'Cobertura Medica',
                'Tipo Pension',
                'Programa Social'
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
