<?php

namespace App\Imports;

use App\Models\Manager\AddressData;
use App\Models\Manager\AditionalData;
use App\Models\Manager\CbiData;
use App\Models\Manager\ContactData;
use App\Models\Manager\Cud;
use App\Models\Manager\EducationData;
use App\Models\Manager\Person;
use App\Models\Manager\SaludData;
use App\Models\Manager\SocialData;
use App\Models\Manager\Tramite;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithBatchInserts;

class InfanciaDevImport implements ToModel,WithHeadingRow, WithBatchInserts
{
    /**
    * @param Collection $collection
    */

    private $rows = 0;
    private $rowsSuccess = 0;
    private $rowsError = 0;
    private $rowsDuplicados = 0;
    private $entidadesNoRegistradas = '';
    private $registrosDuplidados = '';

    public function model(array $row)
    {
        ++$this->rows;  
        try {
            /* if(strlen($row['anio_inicio']) > 4){
                $row['anio_inicio'] = date("Y", strtotime($row['anio_inicio']));
            }
            
            $row['nino_escuela_localidad_id'] = isset($row['nino_escuela_localidad_id']) ? $row['nino_escuela_localidad_id'] : null;
            $row['person_address_localidad_id'] = isset($row['person_address_localidad_id']) ? $row['person_address_localidad_id'] : null;
            $row['act_varias'] = isset($row['act_varias']) ? $row['act_varias'] : null;
            $row['escuela_infante_id'] = isset($row['escuela_infante_id']) ? $row['escuela_infante_id'] : null;
            $row['nino_localidad_id'] = isset($row['nino_localidad_id']) ? $row['nino_localidad_id'] : null; */

            if($row['person_tramite_rol_tramite_id'] == 1){
                $person = Person::updateOrCreate(
                    [
                        'tipo_documento_id' => $row['person_tipo_documento_id'],
                        'num_documento' => $row['person_num_documento']
                    ],
                    [
                        'lastname' => strtoupper(str_replace(' ', '', $row['person_lastname'])) !== 'NULL' && strtoupper(str_replace(' ', '', $row['person_lastname'])) !== null ? $row['person_lastname'] : null,
                        'name' => strtoupper(str_replace(' ', '', $row['person_name'])) !== 'NULL' && strtoupper(str_replace(' ', '', $row['person_name'])) !== ''  ? $row['person_name'] : null,
                        'fecha_nac' => date("Y-m-d ", strtotime($row['person_fecha_nacimiento'])),
                        'tipo_documento_id' => $row['person_tipo_documento_id'],
                        'num_documento' => $row['person_num_documento']
                    ]
                );
    
                AditionalData::updateOrCreate(
                    [
                        'person_id' => $person->id
                    ],
                    [
                        'cant_hijos' => $row['aditional_data_cant_hijos'] !== 'NULL' && $row['aditional_data_cant_hijos'] !== -1 ? $row['aditional_data_cant_hijos'] : null,
                        'situacion_conyugal_id' => $row['aditional_data_situacion_conyugal_id'] !== 'NULL' && $row['aditional_data_situacion_conyugal_id'] !== -1 ? $row['aditional_data_situacion_conyugal_id'] : null,
                    ]
                );
    
                SocialData::updateOrCreate(
                    [
                        'person_id' => $person->id
                    ],
                    [
                        'tipo_ocupacion_id' => $row['social_data_tipo_ocupacion_id'] !== 'NULL' && $row['social_data_tipo_ocupacion_id'] !== -1 ? $row['social_data_tipo_ocupacion_id'] : null,
                        'programa_social_id' => $row['social_data_programa_social_id'] !== 'NULL' && $row['social_data_programa_social_id'] !== -1 ? $row['social_data_programa_social_id'] : null,
                        'cobertura_medica_id' => $row['social_data_cobertura_medica_id'] !== 'NULL' && $row['social_data_cobertura_medica_id'] !== -1 ? $row['social_data_cobertura_medica_id'] : null,
                        'tipo_pension_id' => $row['social_data_tipo_pension_id'] !== 'NULL' && $row['social_data_tipo_pension_id'] !== -1 ? $row['social_data_tipo_pension_id'] : null,
                    ]
                );
    
                EducationData::updateOrCreate(
                    [
                        'person_id' => $person->id
                    ],
                    [
                        'nivel_educativo_id' => $row['education_data_nivel_educativo_id'] !== 'NULL' && $row['education_data_nivel_educativo_id'] !== -1 ? $row['education_data_nivel_educativo_id'] : null,
                        'estado_educativo_id' => $row['education_data_estado_educativo_id'] !== 'NULL' && $row['education_data_estado_educativo_id'] !== -1 ? $row['education_data_estado_educativo_id'] : null
                    ]
                );
    
                AddressData::updateOrCreate(
                    [
                        'person_id' => $person->id
                    ],
                    [
                        'calle' => strtoupper(str_replace(' ', '', $row['address_data_calle'])) !== 'NULL' ? $row['address_data_calle'] : null,
                        'number' => $row['address_data_number'] !== 'NULL' && $row['address_data_number'] !== -1 ? $row['address_data_number'] : null,
                        'piso' => $row['address_data_piso'] !== 'NULL' && $row['address_data_piso'] !== -1 ? $row['address_data_piso'] : null,
                        'dpto' => $row['address_data_dpto'] !== 'NULL' && $row['address_data_dpto'] !== -1 ? $row['address_data_dpto'] : null,
                        'latitude' => $row['address_data_latitude'] !== 'NULL' && $row['address_data_latitude'] !== -1 ? $row['address_data_latitude'] : null,
                        'longitude' => $row['address_data_longitude'] !== 'NULL' && $row['address_data_longitude'] !== -1 ? $row['address_data_longitude'] : null,
                        'google_address' => $row['address_data_google_address'] !== 'NULL' && $row['address_data_google_address'] !== -1 ? $row['address_data_google_address'] : null,
                        'pais_id' => $row['address_data_pais_id'] !== 'NULL' && $row['address_data_pais_id'] !== -1 ? $row['address_data_pais_id'] : null,
                        'localidad_id' => $row['address_data_localidad_id'] !== 'NULL' && $row['address_data_localidad_id'] !== -1 ? $row['address_data_localidad_id'] : null,
                        'barrio_id' => $row['address_data_barrio_id'] !== 'NULL' && $row['address_data_barrio_id'] !== -1 ? $row['address_data_barrio_id'] : null,
    
                    ]
                );
    
                // contact_data
                ContactData::updateOrCreate(
                    [
                        'person_id' => $person->id
                    ],
                    [
                        'phone' => strtoupper(str_replace(' ', '', $row['contact_data_phone'])) !== 'NULL' ? $row['contact_data_phone'] : null,
                        'celular' => strtoupper(str_replace(' ', '', $row['contact_data_celular'])) !== 'NULL' ? $row['contact_data_celular'] : null,
                        'email' => strtoupper(str_replace(' ', '', $row['contact_data_email'])) !== 'NULL' ? $row['contact_data_email'] : null
                    ]
                );

                // CREO EL TRAMITE
                if(!Tramite::where('num_tramite_legacy', $row['tramite_id'])->first()){

                    $tramite_data = Tramite::Create(
                        [
                            'fecha' => date("Y-m-d ", strtotime($row['tramite_fecha'])),
                            'observacion' => $row['tramite_observacion'],
                            'canal_atencion_id' => $row['tramite_canal_atencion'] !== 'NULL' && $row['tramite_canal_atencion'] !== -1 ? $row['tramite_canal_atencion'] : null,
                            'tipo_tramite_id' => $row['tramite_tipo_tramite_id'] !== 'NULL' && $row['tramite_tipo_tramite_id'] !== -1 ? $row['tramite_tipo_tramite_id'] : null,
                            'dependencia_id' => $row['tramite_dependencia_id'] !== 'NULL' && $row['tramite_dependencia_id'] !== -1 ? $row['tramite_dependencia_id'] : null,
                            'parentesco_id' => $row['tramite_parentesco_id'] !== 'NULL' && $row['tramite_parentesco_id'] !== -1 ? $row['tramite_parentesco_id'] : null,
                            'sede_id' =>$row['tramite_sede_id'] !== 'NULL' && $row['tramite_sede_id'] !== -1 ? $row['tramite_sede_id'] : null,
                            'estado_id' => $row['tramite_estado_id'], 
                            'num_tramite_legacy' => $row['tramite_id']
                        ]
                    );
                    // CARGO DATOS DE CBI
                    CbiData::Create(
                        [
                            'anio_inicio' => $row['cbi_data_anio_inicio'] !== 'NULL' && $row['cbi_data_anio_inicio'] !== -1 ? $row['cbi_data_anio_inicio'] : null,
                            'aut_firmada' => $row['cbi_data_aut_firmada'] !== 'NULL' && $row['cbi_data_aut_firmada'] !== -1 ? $row['cbi_data_aut_firmada'] : null,
                            'aut_retirarse' => $row['cbi_data_aut_retirarse'] !== 'NULL' && $row['cbi_data_aut_retirarse'] !== -1 ? $row['cbi_data_aut_retirarse'] : null,
                            'aut_uso_imagen' =>$row['cbi_data_aut_uso_imagen'] !== 'NULL' && $row['cbi_data_aut_uso_imagen'] !== -1 ? $row['cbi_data_aut_uso_imagen'] : null,
                            'act_varias' => $row['cbi_data_act_varias'] !== 'NULL' && $row['cbi_data_act_varias'] !== -1 ? $row['cbi_data_act_varias'] : null,
                            'act_esporadicas' => $row['cbi_data_act_esporadicas'] !== 'NULL' && $row['cbi_data_act_esporadicas'] !== -1 ? $row['cbi_data_act_esporadicas'] : null,
                            'comedor' => $row['cbi_data_comedor'] !== 'NULL' && $row['cbi_data_comedor'] !== -1 ? $row['cbi_data_comedor'] : null,
                            'estado_cbi_id' => $row['cbi_data_estado_cbi_id'] !== 'NULL' && $row['cbi_data_estado_cbi_id'] !== -1 ? $row['cbi_data_estado_cbi_id'] : null,
                            'estado_gabinete_id'  => $row['cbi_data_estado_gabinete_id'] !== 'NULL' && $row['cbi_data_estado_gabinete_id'] !== -1 ? $row['cbi_data_estado_gabinete_id'] : null,
                            'tramite_id' => $tramite_data['id']
                        ]
                    );
                    // ASOCIO EL TRAMITE
                    $person->tramites()->attach($tramite_data['id'], ['rol_tramite_id' => 1]); // ROL TITULAR
                }

            } elseif($row['person_tramite_rol_tramite_id'] == 2){
                
                /* NIÑO  */
                $nino = Person::updateOrCreate(
                    [
                        'tipo_documento_id' => $row['person_tipo_documento_id'],
                        'num_documento' => $row['person_num_documento']
                    ],
                    [
                        'lastname' => strtoupper(str_replace(' ', '', $row['person_lastname'])) !== 'NULL' && strtoupper(str_replace(' ', '', $row['person_lastname'])) !== null ? $row['person_lastname'] : null,
                        'name' => strtoupper(str_replace(' ', '', $row['person_name'])) !== 'NULL' && strtoupper(str_replace(' ', '', $row['person_name'])) !== ''  ? $row['person_name'] : null,
                        'fecha_nac' => date("Y-m-d ", strtotime($row['person_fecha_nacimiento'])),
                        'tipo_documento_id' => $row['person_tipo_documento_id'],
                        'num_documento' => $row['person_num_documento']
                    ]
                );

                EducationData::updateOrCreate(
                    [
                        'person_id' => $nino->id
                    ],
                    [
                        'nivel_educativo_id' => $row['education_data_nivel_educativo_id'] !== 'NULL' && $row['education_data_nivel_educativo_id'] !== -1 ? $row['education_data_nivel_educativo_id'] : null,
                        'estado_educativo_id' => $row['education_data_estado_educativo_id'] !== 'NULL' && $row['education_data_estado_educativo_id'] !== -1 ? $row['education_data_estado_educativo_id'] : null,
                        'escuela_id' => $row['education_data_escuela_id'] !== 'NULL' && $row['education_data_escuela_id'] !== -1 ? $row['education_data_escuela_id'] : null,
                        'escuela_infante_id' => $row['education_data_escuela_infante_id'] !== 'NULL' && $row['education_data_escuela_infante_id'] !== -1 ? $row['education_data_escuela_infante_id'] : null,
                        'escuela_dependencia_id' => $row['education_data_escuela_dependencia_id'] !== 'NULL' && $row['education_data_escuela_dependencia_id'] !== -1 ? $row['education_data_escuela_dependencia_id'] : null,
                        'escuela_localidad_id' => $row['education_data_escuela_localidad_id'] !== 'NULL' && $row['education_data_escuela_localidad_id'] !== -1 ? $row['education_data_escuela_localidad_id'] : null,
                        'escuela_nivel_id' => $row['education_data_escuela_nivel_id'] !== 'NULL' && $row['education_data_escuela_nivel_id'] !== -1 ? $row['education_data_escuela_nivel_id'] : null,
                        'escuela_turno_id' => $row['education_data_escuela_turno_id'] !== 'NULL' && $row['education_data_escuela_turno_id'] !== -1 ? $row['education_data_escuela_turno_id'] : null,
                        'permanencia' => $row['education_data_permanencia'] !== 'NULL' && $row['education_data_permanencia'] !== -1 ? $row['education_data_permanencia'] : null,
                        'certificado_escolar' => $row['education_data_certificado_escolar'] !== 'NULL' && $row['education_data_certificado_escolar'] !== -1 ? $row['education_data_certificado_escolar'] : null,
                        'observacion' => $row['education_data_observacion'] !== 'NULL' && $row['education_data_observacion'] !== -1 ? $row['education_data_observacion'] : null,
                    ]
                );

                AddressData::updateOrCreate(
                    [
                        'person_id' => $nino->id
                    ],
                    [
                        'calle' => strtoupper(str_replace(' ', '', $row['address_data_calle'])) !== 'NULL' ? $row['address_data_calle'] : null,
                        'number' => $row['address_data_number'] !== 'NULL' && $row['address_data_number'] !== -1 ? $row['address_data_number'] : null,
                        'piso' => $row['address_data_piso'] !== 'NULL' && $row['address_data_piso'] !== -1 ? $row['address_data_piso'] : null,
                        'dpto' => $row['address_data_dpto'] !== 'NULL' && $row['address_data_dpto'] !== -1 ? $row['address_data_dpto'] : null,
                        'latitude' => $row['address_data_latitude'] !== 'NULL' && $row['address_data_latitude'] !== -1 ? $row['address_data_latitude'] : null,
                        'longitude' => $row['address_data_longitude'] !== 'NULL' && $row['address_data_longitude'] !== -1 ? $row['address_data_longitude'] : null,
                        'google_address' => $row['address_data_google_address'] !== 'NULL' && $row['address_data_google_address'] !== -1 ? $row['address_data_google_address'] : null,
                        'pais_id' => $row['address_data_pais_id'] !== 'NULL' && $row['address_data_pais_id'] !== -1 ? $row['address_data_pais_id'] : null,
                        'localidad_id' => $row['address_data_localidad_id'] !== 'NULL' && $row['address_data_localidad_id'] !== -1 ? $row['address_data_localidad_id'] : null,
                        'barrio_id' => $row['address_data_barrio_id'] !== 'NULL' && $row['address_data_barrio_id'] !== -1 ? $row['address_data_barrio_id'] : null,
    
                    ]
                );
    
                ContactData::updateOrCreate(
                    [
                        'person_id' => $nino->id
                    ],
                    [
                        'phone' => strtoupper(str_replace(' ', '', $row['contact_data_phone'])) !== 'NULL' ? $row['contact_data_phone'] : null,
                        'celular' => strtoupper(str_replace(' ', '', $row['contact_data_celular'])) !== 'NULL' ? $row['contact_data_celular'] : null,
                        'email' => strtoupper(str_replace(' ', '', $row['contact_data_email'])) !== 'NULL' ? $row['contact_data_email'] : null
                    ]
                );

                SaludData::updateOrCreate(
                    [
                        'person_id' => $nino->id
                    ],
                    [
                        'apto_medico' => $row['salud_data_apto_medico'] !== 'NULL' && $row['salud_data_apto_medico'] !== -1 ? $row['salud_data_apto_medico'] : null,
                        'libreta_vacunacion' => $row['salud_data_libreta_vacunacion'] !== 'NULL' && $row['salud_data_libreta_vacunacion'] !== -1 ? $row['salud_data_libreta_vacunacion'] : null,
                        'centro_salud_id' => $row['salud_data_centro_salud_id'] !== 'NULL' && $row['salud_data_centro_salud_id'] !== -1 ? $row['salud_data_centro_salud_id'] : null,
                        'estado_salud_id' => $row['salud_data_estado_salud_id'] !== 'NULL' && $row['salud_data_estado_salud_id'] !== -1 ? $row['salud_data_estado_salud_id'] : null,
                        'observacion' => $row['salud_data_observacion'] !== 'NULL' && $row['salud_data_observacion'] !== -1 ? $row['salud_data_observacion'] : null,
                    ]
                );    
                
                $tramite_data = Tramite::where('num_tramite_legacy', $row['tramite_id'])->first();

                if(count($tramite_data->rol_tramite) > 1){
                    $nino->tramites()->attach($tramite_data['id'], ['rol_tramite_id' => 2]); // ROL BENEFICIARIO
                }
            }

            ++$this->rowsSuccess;
           
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            ++$this->rowsError;
            $this->entidadesNoRegistradas .= ' - Tramite de la Linea N° ' . strval($this->rows + 1) . ' del archivo no se ha sido almacenar. Error: ' . $th->getMessage() . '<br>';
            Log::error("Se ha generado un error al momento de almacenar el tramite de la linea N° " . strval($this->rows + 1), ["Modulo" => "JuventudImport:store", "Usuario" => Auth::user()->id . ": " . Auth::user()->name, "Error" => $th->getMessage()]);
        }
        return;
    }

    public function getStatus()
    {
        $retorno = 'PROCESO DE IMPORTADOR DE TRAMITES FINALIZADO <br>';
        $retorno .= '=====================================<br>';
        $retorno .= 'Se han procesado un total de ' . strval($this->rows) . ' registros <br>';
        $retorno .= 'Se ha registrado un total de ' . strval($this->rowsSuccess) . ' registros correctamente <br>';
        $retorno .= 'Se ha registrado un total de ' . strval($this->rowsDuplicados) . ' registros duplicados <br>';
        $retorno .= 'Se ha registrado un total de ' . strval($this->rowsError) . ' registros con errores <br>';

        if ($this->entidadesNoRegistradas != '') {
            $retorno .= '<br>Registros con Errores<br>';
            $retorno .= '=====================================<br>';
            $retorno .= $this->entidadesNoRegistradas;
        }

        Log::info("Importador de Tramite de Juventud, ejecutado por el usuario:  ".Auth::user()->id . ": " . Auth::user()->name."<br>=> ".$retorno);

        if ($this->registrosDuplidados != '') {
            $retorno .= '<br>Registros Duplicados<br>';
            $retorno .= '=====================================<br>';
            $retorno .= $this->registrosDuplidados;
        }

        return $retorno;
    }

    public function batchSize(): int
    {
        return 1000;
    }
}
