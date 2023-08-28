<?php

namespace App\Imports;

use App\Models\Manager\AddressData;
use App\Models\Manager\AditionalData;
use App\Models\Manager\ContactData;
use App\Models\Manager\Cud;
use App\Models\Manager\EducationData;
use App\Models\Manager\Person;
use App\Models\Manager\SocialData;
use App\Models\Manager\Tramite;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class FortalecimientoImport implements ToModel,WithHeadingRow
{
    private $rows = 0;
    private $rowsSuccess = 0;
    private $rowsError = 0;
    private $rowsDuplicados = 0;
    private $entidadesNoRegistradas = '';
    private $registrosDuplidados = '';

    public function model(array $row)
    {
        set_time_limit(120);
        ++$this->rows;  
            try {
                if(!Tramite::where('num_tramite_legacy', $row['tramite_num_tramite_legacy'])->first()){
                    $person = Person::updateOrCreate(
                        [
                            'tipo_documento_id' => $row['person_tipo_documento_id'],
                            'num_documento' => $row['person_num_documento']
                        ],
                        [
                            'lastname' => $row['person_lastname'],
                            'name' => $row['person_name'],
                            'fecha_nac' => $row['person_fecha_nac'],
                            'tipo_documento_id' => $row['person_tipo_documento_id'],
                            'num_documento' => $row['person_num_documento']
                        ]
                    );
        
                    AditionalData::updateOrCreate(
                        [
                            'person_id' => $person->id
                        ],
                        [
                            'cant_hijos' => $row['aditional_cant_hijos'],
                            'situacion_conyugal_id' => $row['aditional_situacion_conyugal_id'] !== 'NULL' && $row['aditional_situacion_conyugal_id'] !== -1 ? $row['aditional_situacion_conyugal_id'] : null
                        ]
                    );
        
                    SocialData::updateOrCreate(
                        [
                            'person_id' => $person->id
                        ],
                        [
                            'tipo_ocupacion_id' => $row['social_tipo_ocupacion_id'] !== 'NULL' && $row['social_tipo_ocupacion_id'] !== -1 ? $row['social_tipo_ocupacion_id'] : null,
                            'cobertura_medica_id' => $row['social_cobertura_medica_id'] !== 'NULL' && $row['social_cobertura_medica_id'] !== -1 ? $row['social_cobertura_medica_id'] : null,
                            'tipo_pension_id' => $row['social_tipo_pension_id'] !== 'NULL' && $row['social_tipo_pension_id'] !== -1 ? $row['social_tipo_pension_id'] : null,
                            /* 'programa_social_id' => $row['social_programa_social_id'] */
                        ]
                    );
        
                    EducationData::updateOrCreate(
                        [
                            'person_id' => $person->id
                        ],
                        [
                            'nivel_educativo_id' => $row['education_nivel_educativo_id'] !== 'NULL' && $row['education_nivel_educativo_id'] !== -1 ? $row['education_nivel_educativo_id'] : null,
                            'estado_educativo_id' => $row['education_estado_educativo_id'] !== 'NULL' && $row['education_estado_educativo_id'] !== -1 ? $row['education_estado_educativo_id'] : null
                        ]
                    );
        
                    // address_data
        
                    AddressData::updateOrCreate(
                        [
                            'person_id' => $person->id
                        ],
                        [
                            'calle' => $row['address_calle'] !== 'NULL' ? $row['address_calle'] : null,
                            'number' => $row['address_number'] !== 'NULL' ? $row['address_number'] : null,
                            'piso' => $row['address_piso'] !== 'NULL' ? $row['address_piso'] : null,
                            'dpto' => $row['address_dpto'] !== 'NULL' ? $row['address_dpto'] : null,
                            'latitude' => $row['address_latitude'] !== 'NULL' ? $row['address_latitude'] : null,
                            'longitude' => $row['address_longitude'] !== 'NULL' ? $row['address_longitude'] : null,
                            'google_address' => $row['address_google_address'] !== 'NULL' ? $row['address_google_address'] : null,
                            'pais_id' => $row['address_pais_id'] !== 'NULL' && $row['address_pais_id'] !== -1 ? $row['address_pais_id'] : null,
                            'localidad_id' => $row['address_localidad_id'] !== 'NULL' && $row['address_localidad_id'] !== -1 ? $row['address_localidad_id'] : null,
                            'barrio_id' => $row['address_barrio_id'] !== 'NULL' && $row['address_barrio_id'] !== -1 ? $row['address_barrio_id'] : null
        
                        ]
                    );
        
                    // contact_data
        
                    ContactData::updateOrCreate(
                        [
                            'person_id' => $person->id
                        ],
                        [
                            'phone' => $row['contact_phone'] !== 'NULL' ? $row['contact_phone'] : null,
                            'email' => $row['contact_email'] !== 'NULL' ? $row['contact_email'] : null
                        ]
                    );

                    $tramite_data = Tramite::Create(
                        [
                            'fecha' => date("Y-m-d ", strtotime($row['tramite_fecha'])),
                            'canal_atencion_id' => $row['tramite_canal_atencion_id'],
                            'tipo_tramite_id' => $row['tramite_tipo_tramite_id'],
                            'dependencia_id' => $row['tramite_dependencia_id'],
                            'num_tramite_legacy' => $row['tramite_num_tramite_legacy']
                        ]
                    );
                    $person->tramites()->attach($tramite_data['id'], ['rol_tramite_id' => 1]); // ROL TITULAR

                    ++$this->rowsSuccess; 
                    Log::info("Se ha importado correctamente la entidad N° , bajo el ID de entidad N° ", ["Modulo" => "FortalecimientoEntidad:store","Usuario" => Auth::user()->id.": ".Auth::user()->name]);
                }else{
                    ++$this->rowsDuplicados; 
                    $this->registrosDuplidados .= ' - Entidad N° , correspondiente a la Linea N° '. strval($this->rows+1).' del archivo ha sido cargado previamente. <br>'; 
                    Log::info("La entidad N° , ha sido cargado previamente", ["Modulo" => "FortalecimientoEntidad:store","Usuario" => Auth::user()->id.": ".Auth::user()->name]);
                }
            }catch (\Throwable $th) {
                dd($th);
                ++$this->rowsError;
                $this->entidadesNoRegistradas .= ' - Entidad N° , correspondiente a la Linea N° '. strval($this->rows+1).' del archivo no se ha sido almacenar. Error: '.strstr($th->getMessage(), "(SQL", true).'<br>'; 
                Log::error("Se ha generado un error al momento de almacenar la entidad N° ", ["Modulo" => "FortalecimientoEntidad:store","Usuario" => Auth::user()->id.": ".Auth::user()->name, "Error" => $th->getMessage() ]);
            }
        return; 

    }

    public function getStatus() 
    {
        $retorno = 'PROCESO DE IMPORTADOR DE ENTIDADES FINALIZADO <br>';
        $retorno .= '=====================================<br>';
        $retorno .= 'Se han procesado un total de '.strval($this->rows).' registros <br>';
        $retorno .= 'Se ha registrado un total de '.strval($this->rowsSuccess). ' registros correctamente <br>';
        $retorno .= 'Se ha registrado un total de '.strval($this->rowsDuplicados). ' registros duplicados <br>';
        $retorno .= 'Se ha registrado un total de '.strval($this->rowsError). ' registros con errores <br>';
        
        if($this->entidadesNoRegistradas != ''){
            $retorno .= '<br>Registros con Errores<br>';
            $retorno .= '=====================================<br>';
            $retorno .= $this->entidadesNoRegistradas;
        }

        if($this->registrosDuplidados != ''){
            $retorno .= '<br>Registros Duplicados<br>';
            $retorno .= '=====================================<br>';
            $retorno .= $this->registrosDuplidados;
        }

        return $retorno;
    }
}
