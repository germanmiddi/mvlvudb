<?php

namespace App\Exports;

use App\Models\Manager\CbiData;
use App\Models\Manager\Person;
use App\Models\Manager\Tramite;
use App\Models\User;
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
use Maatwebsite\Excel\Concerns\FromArray;

use Maatwebsite\Excel\Concerns\WithTitle;

class TramitesCBIExport implements FromArray, WithHeadings, WithStyles, ShouldAutoSize, WithColumnFormatting, WithTitle, WithCustomStartCell
{

    use Exportable;
    /**
    * @return \Illuminate\Support\Collection
    */

    protected $data;

    function __construct() {
        
    }

    public function array(): array
    {
        
        $result = Tramite::query();
        $pos = 0; 
        $tramites = Tramite::where('dependencia_id',12)->get()->toArray();

        foreach ($tramites as $tramite) {
            // Ejecutar una consulta directa
            $query = "SELECT * FROM person_tramite WHERE tramite_id =".$tramite['id'];
            $person_tramite = DB::select($query);
            
            foreach ($person_tramite as $pt) {
                // Recorro las personas asociadas, y se cargan los datos del tramite. 
                $data_temp = [];
                $data_temp['id'] = $tramite['id'] + 12000000;
                $data_temp['fecha'] = $tramite['fecha'];
                $data_temp['observacion'] = $tramite['observacion'];
                $data_temp['sede_id'] = $tramite['sede_id'];
                $data_temp['canal_atencion_id'] = $tramite['canal_atencion_id'];
                $data_temp['tipo_tramite_id'] = $tramite['tipo_tramite_id'];
                $data_temp['tipo_institucion_id'] = $tramite['tipo_institucion_id'];
                $data_temp['dependencia_id'] = $tramite['dependencia_id'];
                $data_temp['num_tramite_legacy'] = $tramite['num_tramite_legacy'];
                $data_temp['parentesco_id'] = $tramite['parentesco_id'];
                $data_temp['estado_id'] = $tramite['estado_id'];
                $data_temp['assigned'] = $tramite['assigned'];
                $data_temp['users_email'] = User::where('users.id', $tramite['assigned'])->first()->email ?? '';
                $data_temp['category_id'] = $tramite['category_id'];
                $data_temp['modalidad_atencion_id'] = $tramite['modalidad_atencion_id'];
                //Person_tramite
                $data_temp['person_rol_tramite_id'] = $pt->rol_tramite_id;
                //Person
                $person = Person::where('id', $pt->person_id)->first();

                $data_temp['person_name'] = $person->name;
                $data_temp['person_lastname'] = $person->lastname;
                $data_temp['person_num_documento'] = $person->num_documento;
                $data_temp['person_tipo_documento_id'] = $person->tipo_documento_id;
                $data_temp['person_fecha_nacimiento'] = $person->fecha_nac;

                //Data_address
                $data_temp['address_data_localidad_id'] = $person->address[0]->localidad_id;
                $data_temp['address_data_pais_id'] = $person->address[0]->pais_id;
                $data_temp['address_data_barrio_id'] = $person->address[0]->barrio_id;
                $data_temp['address_data_calle'] = $person->address[0]->calle;
                $data_temp['address_data_number'] = $person->address[0]->number;
                $data_temp['address_data_piso'] = $person->address[0]->piso;
                $data_temp['address_data_dpto'] = $person->address[0]->dpto;
                $data_temp['address_data_latitude'] = $person->address[0]->latitude;
                $data_temp['address_data_longitude'] = $person->address[0]->longitude;
                $data_temp['address_data_google_address'] = $person->address[0]->google_address;

                //Data_aditional
                $data_temp['aditional_data_cant_hijos'] = $person->aditional[0]->cant_hijos ?? null;
                $data_temp['aditional_data_tipo_vivienda_id'] = $person->aditional[0]->tipo_vivienda_id ?? null;
                $data_temp['aditional_data_tipo_vinculo_familiar_id'] = $person->aditional[0]->tipo_vinculo_familiar_id ?? null;
                $data_temp['aditional_data_situacion_conyugal_id'] = $person->aditional[0]->situacion_conyugal_id ?? null;

                //Data_contact
                $data_temp['contact_data_phone'] = $person->contact[0]->phone;
                $data_temp['contact_data_celular'] = $person->contact[0]->celular;
                $data_temp['contact_data_email'] = $person->contact[0]->email;

                // Data_salud
                if($person->salud){
                    $data_temp['salud_data_apto_medico'] = $person->salud->apto_medico == 1 ? '1' : ($person->salud->apto_medico === null ? null : '0');
                    $data_temp['salud_data_libreta_vacunacion'] = $person->salud->libreta_vacunacion == 1 ? '1' : ($person->salud->libreta_vacunacion === null ? null : '0');
                    $data_temp['salud_data_fecha_apto_medico'] = $person->salud->fecha_apto_medico ?? null;
                    $data_temp['salud_data_electrocardiograma'] = $person->salud->electrocardiograma == 1 ? '1' : ($person->salud->electrocardiograma === null ? null : '0');
                    $data_temp['salud_data_fecha_electrocardiograma'] = $person->salud->fecha_electrocardiograma ?? null;
                    $data_temp['salud_data_medicacion'] = $person->salud->medicacion == 1 ? '1' : ($person->salud->medicacion === null ? null : '0');
                    $data_temp['salud_data_name_medicacion'] = $person->salud->name_medicacion ?? null;
                    $data_temp['salud_data_dosis'] = $person->salud->dosis ?? null;
                    $data_temp['salud_data_observacion'] = $person->salud->observacion ?? null;
                    $data_temp['salud_data_centro_salud_id'] = $person->salud->centro_salud_id ?? null;
                    $data_temp['salud_data_estado_salud_id'] = $person->salud->estado_salud_id ?? null;
                }else{
                    $data_temp['salud_data_apto_medico'] = null;
                    $data_temp['salud_data_libreta_vacunacion'] = null;
                    $data_temp['salud_data_fecha_apto_medico'] = null;
                    $data_temp['salud_data_electrocardiograma'] = null;
                    $data_temp['salud_data_fecha_electrocardiograma'] = null;
                    $data_temp['salud_data_medicacion'] = null;
                    $data_temp['salud_data_name_medicacion'] = null;
                    $data_temp['salud_data_dosis'] = null;
                    $data_temp['salud_data_observacion'] = null;
                    $data_temp['salud_data_centro_salud_id'] = null;
                    $data_temp['salud_data_estado_salud_id'] = null;
                }

                
                // Data_social
                $data_temp['social_data_tipo_ocupacion_id'] = $person->social[0]->tipo_ocupacion_id ?? null;
                $data_temp['social_data_cobertura_medica_id'] = $person->social[0]->cobertura_medica_id ?? null;
                $data_temp['social_data_tipo_pension_id'] = $person->social[0]->tipo_pension_id ?? null;
                $data_temp['social_data_programa_social_id'] = $person->social[0]->programa_social_id ?? null;

                // Data_education
                $data_temp['education_data_nivel_educativo_id'] = $person->education[0]->nivel_educativo_id ?? null;
                $data_temp['education_data_estado_educativo_id'] = $person->education[0]->estado_educativo_id ?? null;
                $data_temp['education_data_escuela_id'] = $person->education[0]->escuela_id ?? null;
                $data_temp['education_data_escuela_infante_id'] = $person->education[0]->escuela_infante_id ?? null;
                $data_temp['education_data_escuela_dependencia_id'] = $person->education[0]->escuela_dependencia_id ?? null;
                $data_temp['education_data_escuela_localidad_id'] = $person->education[0]->escuela_localidad_id ?? null;
                $data_temp['education_data_escuela_nivel_id'] = $person->education[0]->escuela_nivel_id ?? null;
                $data_temp['education_data_escuela_turno_id'] = $person->education[0]->escuela_turno_id ?? null;
                $data_temp['education_data_permanencia'] = $person->education[0]->permanencia == 1 ? '1' : ($person->education[0]->permanencia === null ? null : '0');
                $data_temp['education_data_certificado_escolar'] = $person->education[0]->certificado_escolar == 1 ? '1' : ($person->education[0]->certificado_escolar === null ? null : '0');
                $data_temp['education_data_observacion'] = $person->education[0]->observacion ?? null;
                
                //CBI DATA
                $cbi_data = CbiData::where('tramite_id', $tramite['id'])->first();
                $data_temp['cbi_data_anio_inicio'] = $cbi_data->anio_inicio;
                $data_temp['cbi_data_aut_firmada'] = $cbi_data->aut_firmada == 1 ? '1' : ($cbi_data->aut_firmada === null ? null : '0');
                $data_temp['cbi_data_aut_retirarse'] = $cbi_data->aut_retirarse == 1 ? '1' : ($cbi_data->aut_retirarse === null ? null : '0');
                $data_temp['cbi_data_aut_uso_imagen'] = $cbi_data->aut_uso_imagen == 1 ? '1' : ($cbi_data->aut_uso_imagen === null ? null : '0');
                $data_temp['cbi_data_act_varias'] = $cbi_data->act_varias == 1 ? '1' : ($cbi_data->act_varias === null ? null : '0');
                $data_temp['cbi_data_act_esporadicas'] = $cbi_data->act_esporadicas == 1 ? '1' : ($cbi_data->act_esporadicas === null ? null : '0');
                $data_temp['cbi_data_comedor'] = $cbi_data->comedor == 1 ? '1' : ($cbi_data->comedor === null ? null : '0');
                $data_temp['cbi_data_estado_cbi_id'] = $cbi_data->estado_cbi_id;
                $data_temp['cbi_data_estado_gabinete_id'] = $cbi_data->estado_gabinete_id;

                $this->data[$pos] = $data_temp;
                $pos++;
            }
        }
        return $this->data;
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
                'person_tramite_rol_tramite_id',
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
                'salud_data_apto_medico','salud_data_libreta_vacunacion','salud_data_fecha_apto_medico','salud_data_electrocardiograma','salud_data_fecha_electrocardiograma',
                'salud_data_medicacion','salud_data_name_medicacion','salud_data_dosis','salud_data_observacion','salud_data_centro_salud_id','salud_data_estado_salud_id',
                // Data_social
                'social_data_tipo_ocupacion_id','social_data_cobertura_medica_id','social_data_tipo_pension_id','social_data_programa_social_id',
                // Data_education
                'education_data_nivel_educativo_id','education_data_estado_educativo_id','education_data_escuela_id',
                'education_data_escuela_infante_id','education_data_escuela_dependencia_id','education_data_escuela_localidad_id',
                'education_data_escuela_nivel_id','education_data_escuela_turno_id','education_data_permanencia',
                'education_data_certificado_escolar','education_data_observacion',
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
