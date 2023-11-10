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

class TramitesCBIExport implements FromCollection, WithHeadings, WithStyles, ShouldAutoSize, WithColumnFormatting, WithTitle, WithCustomStartCell
{

    use Exportable;
    /**
    * @return \Illuminate\Support\Collection
    */

    protected $data;

    function __construct() {
        
    }

    public function collection()
    {
        
        $result = Tramite::query();

        $result->select(
            // Data Tramite
            'tramites.id', DB::raw("DATE_FORMAT(tramites.fecha, '%d-%m-%Y')"), 'tramites.observacion',
            'tramites.sede_id','tramites.canal_atencion_id','tramites.tipo_tramite_id',
            'tramites.tipo_institucion_id', 'tramites.dependencia_id', 'tramites.num_tramite_legacy',
            'tramites.parentesco_id','tramites.estado_id','tramites.assigned','users.email',
            'tramites.category_id', 'tramites.modalidad_atencion_id', 
            //Person_tramite Data
            'person_tramite.person_id','person_tramite.tramite_id', 'person_tramite.rol_tramite_id',
            //Person Data
            'person.name', 
            'person.lastname', 
            'person.num_documento',
            'person.tipo_documento_id',
            DB::raw("DATE_FORMAT(person.fecha_nac, '%d-%m-%Y')"), 
            // Data Address
            'address_data.localidad_id', 'address_data.pais_id','address_data.barrio_id','address_data.calle',
            'address_data.number','address_data.piso','address_data.dpto','address_data.latitude',
            'address_data.longitude','address_data.google_address',  
            // Data Aditional
            'aditional_data.cant_hijos','aditional_data.tipo_vivienda_id','aditional_data.tipo_vinculo_familiar_id',
            'aditional_data.situacion_conyugal_id',
            // Data Contact
            'contact_data.phone','contact_data.celular','contact_data.email',
            // Data_salud
            'salud_data.apto_medico','salud_data.libreta_vacunacion',DB::raw("DATE_FORMAT(salud_data.fecha_apto_medico, '%d-%m-%Y')"),
            'salud_data.electrocardiograma', DB::raw("DATE_FORMAT(salud_data.fecha_electrocardiograma, '%d-%m-%Y')"),
            'salud_data.medicacion','salud_data.name_medicacion','salud_data.dosis','salud_data.observacion',
            'salud_data.centro_salud_id','salud_data.estado_salud_id',
            // Data_social
            'social_data.tipo_ocupacion_id','social_data.cobertura_medica_id','social_data.tipo_pension_id',
            'social_data.programa_social_id',
            // CBI Data
            'cbi_data.anio_inicio','cbi_data.aut_firmada','cbi_data.aut_retirarse','cbi_data.aut_uso_imagen',
            'cbi_data.act_varias','cbi_data.act_esporadicas','cbi_data.comedor','cbi_data.estado_cbi_id','cbi_data.estado_gabinete_id')

            ->join('person_tramite', 'person_tramite.tramite_id', '=', 'tramites.id')
            ->join('person', 'person.id', '=', 'person_tramite.person_id')
            ->leftjoin('users', 'users.id', '=', 'tramites.assigned')
            ->leftjoin('cbi_data', 'cbi_data.tramite_id', '=', 'tramites.id')
            ->leftjoin('education_data','education_data.person_id','=', 'person.id')
            ->leftjoin('address_data', 'address_data.person_id', '=', 'person.id')
            ->leftjoin('salud_data', 'salud_data.person_id', '=', 'person.id')
            ->leftjoin('contact_data', 'contact_data.person_id', '=', 'person.id')
            ->leftjoin('aditional_data', 'aditional_data.person_id', '=', 'person.id')
            ->leftjoin('social_data', 'social_data.person_id', '=', 'person.id')
            ->leftjoin('escuelas', 'escuelas.id', '=', 'education_data.escuela_id')
            ->leftjoin('estado_educativo', 'estado_educativo.id', '=', 'education_data.estado_educativo_id')
            ->leftjoin('tipo_ocupacion', 'tipo_ocupacion.id', '=', 'social_data.tipo_ocupacion_id')
            ->leftjoin('tipo_tramite', 'tipo_tramite.id', '=', 'tramites.tipo_tramite_id')
            ->leftjoin('dependencias', 'dependencias.id', '=', 'tramites.dependencia_id')
            ->leftjoin('localidades', 'localidades.id', '=', 'address_data.localidad_id')
            ->leftjoin('barrios', 'barrios.id', '=', 'address_data.barrio_id')
            ->where('tramites.id', '1')
            ->where('tramites.dependencia_id','12');
            //->orderBy('tramites.id');
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
                //tramite
                'tramite_id','tramite_fecha','tramite_observacion','tramite_sede_id','tramite_canal_atencion','tramite_tipo_tramite_id',
                'tramite_tipo_institucion_id', 'tramite_dependencia_id', 'tramite_num_tramite_legacy','tramite_parentesco_id', 
                'tramite_estado_id','tramite_assigned','users_email','tramite_category_id', 'tramite_modalidad_atencion_id',
                //Person_tramite
                'person_tramite_person_id','person_tramite_tramite_id', 'person_tramite_rol_tramite_id',
                //Person
                'person_name','person_lastname','person_num_documento','person_tipo_documento_id','person_fecha_nacimiento',
                //Data_address
                'address_data_localidad_id', 'address_data_pais_id','address_data_barrio_id',
                'address_data_calle','address_data_number','address_data_piso','address_data_dpto','address_data_latitude',
                'address_data_longitude','address_data_google_address',  
                //Data_aditional
                'aditional_data_cant_hijos','aditional_data_tipo_vivienda_id','aditional_data_tipo_vinculo_familiar_id','aditional_data_situacion_conyugal_id',
                //Data_contact
                'contact_data_phone','contact_data_celular','contact_data_email',
                // Data_salud
                'salud_data_apt_medico','salud_data_libreta_vacunacion','salud_data_fecha_apto_medico','salud_data_electrocardiograma','salud_data_fecha_electrocardiograma',
                'salud_data_medicacion','salud_data_name_medicacion','salud_data_dosis','salud_data_observacion','salud_data_centro_salud_id','salud_data_estado_salud_id',
                // Data_social
                'social_data_tipo_ocupacion_id','social_data_cobertura_medica_id','social_data_tipo_pension_id','social_data_programa_social_id',
                //CBI DATA
                'cbi_data_anio_inicio','cbi_data_aut_firmada','cbi_data_aut_retirarse','cbi_data_aut_uso_imagen','cbi_data_act_varias','cbi_data_act_esporadicas','cbi_data_comedor', 
                'cbi_data_estado_cbi_id','cbi_data_estado_gabinete_id'
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
