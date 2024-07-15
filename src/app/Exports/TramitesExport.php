<?php

namespace App\Exports;

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

class TramitesExport implements FromCollection, WithHeadings, WithStyles, ShouldAutoSize, WithColumnFormatting, WithTitle, WithCustomStartCell
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
        
        $result = Tramite::query();
        $depe = true;
        $result->select(
                'tramites.id',
                'person.name', 
                'person.lastname', 
                'person.num_documento',
                DB::raw("DATE_FORMAT(person.fecha_nac, '%d-%m-%Y')"), 
                'contact_data.phone',
                'contact_data.celular',
                'contact_data.email',
                'localidades.description', 
                'barrios.description as barrio_description',
                'address_data.calle',
                'address_data.number',
                'address_data.piso',
                'address_data.dpto',
                'address_data.google_address',
                'paises.description as paises_description',
                'situacion_conyugal.description as situacion_conyugal_description',
                'aditional_data.cant_hijos as aditional_data_cant_hijos',
                'nivel_educativo.description as nivel_educativo_actual',
                'escuelas.description AS escuela_description', 
                'estado_educativo.description AS estado_educativo',
                'tipo_ocupacion.description AS tipo_ocupacion_description',
                'tipo_pension.description AS tipo_pension_description',
                'cobertura_medica.description AS cobertura_medica_description',
                'programa_social.description AS programa_social_description',
                DB::raw("DATE_FORMAT(tramites.fecha, '%d-%m-%Y')"),
                'tipo_tramite.description AS tipo_tramite_description',
                'dependencias.description AS dependencia_description',
                'tramites.observacion',
                'modalidad_atencion.description AS modalidad_atencion_description',
                DB::raw("IF(".$this->data['dependencia_id']." = 6, IF(tramite_data.ingreso_nuevo IS NOT NULL, IF(tramite_data.ingreso_nuevo, 'SI', 'NO'), '-'), '') AS ingreso_nuevo"),
                DB::raw("IF(".$this->data['dependencia_id']." = 6, IF(tramite_data.boton_antipanico IS NOT NULL, IF(tramite_data.boton_antipanico, 'SI', 'NO'), '-'), '') AS boton_antipanico"),
                'categories.nombre AS categories_nombre')

            ->join('person_tramite', 'person_tramite.tramite_id', '=', 'tramites.id')
            ->join('person', 'person.id', '=', 'person_tramite.person_id')
            ->leftjoin('education_data','education_data.person_id','=', 'person.id')
            ->leftjoin('address_data', 'address_data.person_id', '=', 'person.id')
            ->leftjoin('contact_data', 'contact_data.person_id', '=', 'person.id')
            ->leftjoin('social_data', 'social_data.person_id', '=', 'person.id')
            ->leftjoin('escuelas', 'escuelas.id', '=', 'education_data.escuela_id')
            ->leftjoin('estado_educativo', 'estado_educativo.id', '=', 'education_data.estado_educativo_id')
            ->leftjoin('tipo_ocupacion', 'tipo_ocupacion.id', '=', 'social_data.tipo_ocupacion_id')
            ->leftjoin('tipo_tramite', 'tipo_tramite.id', '=', 'tramites.tipo_tramite_id')
            ->leftjoin('dependencias', 'dependencias.id', '=', 'tramites.dependencia_id')
            ->leftjoin('localidades', 'localidades.id', '=', 'address_data.localidad_id')
            ->leftjoin('barrios', 'barrios.id', '=', 'address_data.barrio_id')
            ->leftjoin('tramite_data', 'tramite_data.tramite_id', '=', 'tramites.id')
            ->leftjoin('modalidad_atencion', 'modalidad_atencion.id', '=', 'tramites.modalidad_atencion_id')
            ->leftjoin('categories', 'categories.id', '=', 'tramites.category_id')
            ->leftjoin('paises', 'paises.id', '=', 'address_data.pais_id')
            ->leftjoin('aditional_data', 'aditional_data.person_id', '=', 'person.id')
            ->leftjoin('situacion_conyugal', 'situacion_conyugal.id', '=', 'aditional_data.situacion_conyugal_id')
            ->leftjoin('nivel_educativo', 'nivel_educativo.id', '=', 'education_data.nivel_educativo_id')
            ->leftjoin('tipo_pension', 'tipo_pension.id', '=', 'social_data.tipo_pension_id')
            ->leftjoin('cobertura_medica', 'cobertura_medica.id', '=', 'social_data.cobertura_medica_id')
            ->leftjoin('programa_social', 'programa_social.id', '=', 'social_data.programa_social_id')
            ->where('person_tramite.rol_tramite_id', '1');

        if(isset($this->data['dependencia_id'])){
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
        }

        if(isset($this->data['name'])){
            $name = json_decode($this->data['name']);  
            $result->whereIn('id', function ($sub) use($name) {
                        $sub->selectRaw('tramites.id')
                            ->from('tramites')
                            ->join('person_tramite', 'tramites.id', '=', 'person_tramite.tramite_id')
                            ->join('person', 'person.id', '=', 'person_tramite.person_id')
                            ->where('person.name', 'LIKE', '%'.$name.'%')
                            ->orWhere('person.lastname', 'LIKE', '%'.$name.'%');
                    });
        }
        if(isset($this->data['num_documento'])){
            $num_documento = json_decode($this->data['num_documento']);  
            $result->whereIn('id', function ($sub) use($num_documento) {
                        $sub->selectRaw('tramites.id')
                            ->from('tramites')
                            ->join('person_tramite', 'tramites.id', '=', 'person_tramite.tramite_id')
                            ->join('person', 'person.id', '=', 'person_tramite.person_id')
                            ->where('person.num_documento', 'LIKE', '%'.$num_documento.'%');
                    });
        }

        //dd($this->data['ingreso_nuevo']);
        if(isset($this->data['boton_antipanico'])){
            $boton_antipanico = json_decode($this->data['boton_antipanico']);  
        
            $result->whereIn('tramites.id', function ($sub) use($boton_antipanico) {
                        $sub->selectRaw('tramites.id')
                            ->from('tramites')
                            ->join('tramite_data', 'tramite_data.tramite_id', '=', 'tramites.id')
                            ->where('tramite_data.boton_antipanico', '=', $boton_antipanico);
                    });
        }

        if(isset($this->data['ingreso_nuevo'])){
            $ingreso_nuevo = $this->data['ingreso_nuevo'];  

            $result->whereIn('tramites.id', function ($sub) use($ingreso_nuevo) {
                        $sub->selectRaw('tramites.id')
                            ->from('tramites')
                            ->join('tramite_data', 'tramite_data.tramite_id', '=', 'tramites.id')
                            ->where('tramite_data.ingreso_nuevo', '=', $ingreso_nuevo);
                    });
        }

        if(isset($this->data['modalidad_atencion_id'])){
            $result->where('tramites.modalidad_atencion_id', $this->data['modalidad_atencion_id']);
        }

        if(isset($this->data['categoria_id'])){
            $result->where('tramites.category_id', $this->data['categoria_id']);
        }

        if(isset($this->data['user_id'])){
            $result->where('tramites.assigned', $this->data['user_id']);
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
        $title = [
            'Nro Trámite',
            'Nombre',
            'Apellido',
            'Num. Documento',
            'Fecha Nacimiento',
            'Telefono',
            'Celular',
            'Email',
            'Localidad',
            'Barrio',
            'Calle',
            'Numero',
            'Piso',
            'Dpto',
            'Direccion Google',
            'País',
            'Situacion Conyugal',
            'Cant. Hijos',
            'Niv. Educ. en curso',
            'Escuela',
            'Estado Educativo',
            'Ocupación',
            'Jub./Pens.',
            'Cobertura Salud',
            'Programa Social',
            'Fecha Tramite',
            'Tipo Tramite',
            'Dependencia',
            //'Nomenclatura', //No se utiliza
            'Observacion',
        ];
        if ($this->data['dependencia_id'] === 2 || $this->data['dependencia_id'] === 6 || $this->data['dependencia_id'] === 14) {
            $title[] = 'Modalidad de Atencion';
            if($this->data['dependencia_id'] === 6){
                $title[] = 'Ingreso Nuevo';
                $title[] = 'Boton Antipanico';
                $title[] = 'Categoría';
            }
        }
        return $title;
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
