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
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;

class NinezImport implements ToModel,WithHeadingRow, WithBatchInserts, WithChunkReading
{
    private $rows = 0;
    private $rowsSuccess = 0;
    private $rowsError = 0;
    private $rowsDuplicados = 0;
    private $entidadesNoRegistradas = '';
    private $registrosDuplidados = '';

    public function model(array $row)
    {
        ++$this->rows;  
        //dd("TRAMITE N° ".$row['tramite_num_tramite_legacy']."  NIÑO: ".$row['menor_person_lastname']);
            /** 
             * Verificar si es Tramite Nuevo o ya un existente previamente 
             * 
             **/
            //if (Tramite::where('num_tramite_legacy', $row['tramite_num_tramite_legacy'])->first()) {
                try{
                    if(strtoupper(str_replace(' ', '', $row['resp_person_fecha_nac'])) !== 'NULL'){
                        $person = Person::updateOrCreate(
                            [
                                'tipo_documento_id' => $row['resp_person_tipo_documento_id'],
                                'num_documento' => $row['resp_person_num_documento']
                            ],
                            [
                                'lastname' => strtoupper(str_replace(' ', '', $row['resp_person_lastname'])) !== 'NULL' ? $row['resp_person_lastname'] : null,
                                'name' => strtoupper(str_replace(' ', '', $row['resp_person_name'])) !== 'NULL' ? $row['resp_person_name'] : null,
                                'fecha_nac' => strtoupper(str_replace(' ', '', $row['resp_person_fecha_nac'])) !== 'NULL' ? $row['resp_person_fecha_nac'] : null,
                                'tipo_documento_id' => $row['resp_person_tipo_documento_id'],
                                'num_documento' => $row['resp_person_num_documento']
                            ]
                        );
                
                        AditionalData::updateOrCreate(
                            [
                                'person_id' => $person->id
                            ],
                            [
                                'cant_hijos' => $row['resp_aditional_cant_hijos'],
                                'situacion_conyugal_id' => $row['resp_aditional_situacion_conyugal_id'] !== 'NULL' ? $row['resp_aditional_situacion_conyugal_id'] : null
                            ]
                        );
                
                        SocialData::updateOrCreate(
                            [
                                'person_id' => $person->id
                            ],
                            [
                                'tipo_ocupacion_id' => $row['resp_social_tipo_ocupacion_id'] !== 'NULL' && $row['resp_social_tipo_ocupacion_id'] !== -1 ? $row['resp_social_tipo_ocupacion_id'] : null,
                                'cobertura_medica_id' => $row['resp_social_cobertura_medica_id'] !== 'NULL' && $row['resp_social_cobertura_medica_id'] !== -1 ? $row['resp_social_cobertura_medica_id'] : null,
                                'tipo_pension_id' => $row['resp_social_tipo_pension_id'] !== 'NULL' && $row['resp_social_tipo_pension_id'] !== -1 ? $row['resp_social_tipo_pension_id'] : null,
                            ]
                        );
                
                        EducationData::updateOrCreate(
                            [
                                'person_id' => $person->id
                            ],
                            [
                                'nivel_educativo_id' => $row['resp_education_nivel_educativo_id'] !== 'NULL' && $row['resp_education_nivel_educativo_id'] !== -1 ? $row['resp_education_nivel_educativo_id'] : null,
                                'estado_educativo_id' => $row['resp_education_estado_educativo_id'] !== 'NULL' && $row['resp_education_estado_educativo_id'] !== -1 ? $row['resp_education_estado_educativo_id'] : null
                            ]
                        );
                
                        // address_data
                
                        AddressData::updateOrCreate(
                            [
                                'person_id' => $person->id
                            ],
                            [
                                'calle' => strtoupper(str_replace(' ', '', $row['resp_address_calle'])) !== 'NULL' ? $row['resp_address_calle'] : null,
                                'number' => strtoupper(str_replace(' ', '', $row['resp_address_number'])) !== 'NULL' ? $row['resp_address_number'] : null,
                                'piso' => strtoupper(str_replace(' ', '', $row['resp_address_piso'])) !== 'NULL' ? $row['resp_address_piso'] : null,
                                'dpto' => strtoupper(str_replace(' ', '', $row['resp_address_dpto'])) !== 'NULL' ? $row['resp_address_dpto'] : null,
                                'localidad_id' => $row['resp_address_localidad_id'] !== 'NULL' && $row['resp_address_localidad_id'] !== -1 ? $row['resp_address_localidad_id'] : null,
                                //'barrio_id' => $row['resp_address_barrio_id'] !== 'NULL' ? $row['resp_address_barrio_id'] : null
                
                            ]
                        );
                
                        // contact_data
                
                        ContactData::updateOrCreate(
                            [
                                'person_id' => $person->id
                            ],
                            [
                                'phone' => strtoupper(str_replace(' ', '', $row['resp_contact_phone'])) !== 'NULL' ? $row['resp_contact_phone'] : null,
                                //'celular' => strtoupper(str_replace(' ', '', $row['resp_contact_celular'])) !== 'NULL' ? $row['resp_contact_celular'] : null,
                                'email' => strtoupper(str_replace(' ', '', $row['resp_contact_email'])) !== 'NULL' ? $row['resp_contact_email'] : null
                            ]
                        );
                
                        if(strtoupper(str_replace(' ', '', $row['menor_person_num_documento'])) !== 'NULL' && strtoupper(str_replace(' ', '', $row['menor_person_fecha_nac'])) !== 'NULL'){
                            $beneficiario = Person::updateOrCreate(
                                [
                                    'tipo_documento_id' => $row['menor_person_tipo_documento_id'],
                                    'num_documento' => $row['menor_person_num_documento']
                                ],
                                [
                                    'lastname' => strtoupper(str_replace(' ', '', $row['menor_person_lastname'])) !== 'NULL' ? $row['menor_person_lastname'] : null,
                                    'name' => strtoupper(str_replace(' ', '', $row['menor_person_name'])) !== 'NULL' ? $row['menor_person_name'] : null,
                                    'fecha_nac' => strtoupper(str_replace(' ', '', $row['menor_person_fecha_nac'])) !== 'NULL' ? $row['menor_person_fecha_nac'] : null,
                                    'tipo_documento_id' => $row['menor_person_tipo_documento_id'],
                                    'num_documento' => $row['menor_person_num_documento']
                                ]
                            );
                
                            AddressData::updateOrCreate(
                                [
                                    'person_id' => $beneficiario->id
                                ],
                                [
                                    'calle' => strtoupper(str_replace(' ', '', $row['menor_address_calle'])) !== 'NULL' ? $row['menor_address_calle'] : null,
                                    'number' => strtoupper(str_replace(' ', '', $row['menor_address_number'])) !== 'NULL' ? $row['menor_address_number'] : null,
                                    'piso' => strtoupper(str_replace(' ', '', $row['menor_address_piso'])) !== 'NULL' ? $row['menor_address_piso'] : null,
                                    'dpto' => strtoupper(str_replace(' ', '', $row['menor_address_dpto'])) !== 'NULL' ? $row['menor_address_dpto'] : null,
                                    'localidad_id' => $row['menor_address_localidad_id'] !== 'NULL' && $row['menor_address_localidad_id'] !== -1 ? $row['menor_address_localidad_id'] : null,
                                ]
                            );
                        }
    
                        // CONTROLO SI EL BENEFICIARIO ES VALIDO
                        if(isset($beneficiario)){
                            // Busco posibles tramite legacy.
                            $tramites = Tramite::where('num_tramite_legacy', $row['tramite_num_tramite_legacy'])->get();
    
                            $existeTramiteNino = false;
                            $idTramite = '';
    
                            // Verifico si existe tramite legacy con dicho niño asociado.
                            if ($tramites) {
                                foreach ($tramites as $tramite) {
                                    if($tramite->rol_tramite->contains('id', 2)){
                                        foreach ($tramite->persons as $p) {
                                            if ($p->rol_tramite->contains('id', 2)  && $p->num_documento === $row['menor_person_num_documento'] ) {
                                                $existeTramiteNino = true;
                                                $idTramite = $tramite->id;
                                            }
                                        }
                                    }
                                }
    
                                if($existeTramiteNino){
                                    //Si existe el tramite lo actualizo
                                    $tramite_data = Tramite::where('id', $idTramite)->update(
                                        [
                                            'fecha' => date("Y-m-d ", strtotime($row['tramite_fecha'])),
                                            'canal_atencion_id' => $row['tramite_canal_atencion_id'],
                                            'tipo_tramite_id' => $row['tramite_tipo_tramite_id'],
                                            'dependencia_id' => $row['tramite_dependencia_id'],
                                            'parentesco_id' => $row['tramite_parentesco_id'] !== 'NULL' && $row['tramite_parentesco_id'] !== -1 ? $row['tramite_parentesco_id'] : null,
                                            'estado_id' => $row['tramite_estado_id'],
                                            'observacion' => $row['tramite_observacion'] !== 'NULL' && $row['tramite_observacion'] !== -1 ? $row['tramite_observacion'] : '',
                                            'num_tramite_legacy' => $row['tramite_num_tramite_legacy']
                                        ]
                                    );
                                    ++$this->rowsDuplicados;
                                    $this->registrosDuplidados .= ' - Tramite correspondiente a la Linea N° ' . strval($this->rows + 1) . ' del archivo ha sido cargado previamente. <br>';
                                }else{
                                    // Si no existe tramite creo un nuevo tramite y lo asocio.
                                    $tramite_data = Tramite::Create(
                                        [
                                            'fecha' => date("Y-m-d ", strtotime($row['tramite_fecha'])),
                                            'canal_atencion_id' => $row['tramite_canal_atencion_id'],
                                            'tipo_tramite_id' => $row['tramite_tipo_tramite_id'],
                                            'dependencia_id' => $row['tramite_dependencia_id'],
                                            'parentesco_id' => $row['tramite_parentesco_id'] !== 'NULL' && $row['tramite_parentesco_id'] !== -1 ? $row['tramite_parentesco_id'] : null,
                                            'estado_id' => $row['tramite_estado_id'],
                                            'observacion' => $row['tramite_observacion'] !== 'NULL' && $row['tramite_observacion'] !== -1 ? $row['tramite_observacion'] : '',
                                            'num_tramite_legacy' => $row['tramite_num_tramite_legacy']
                                        ]
                                    );
                                    $person->tramites()->attach($tramite_data['id'], ['rol_tramite_id' => 1]); // ROL TITULAR
                                    $beneficiario->tramites()->attach($tramite_data['id'], ['rol_tramite_id' => 2]); // ROL BENEFICIARIO
                                    ++$this->rowsDuplicados;
                                    $this->registrosDuplidados .= ' - Tramite correspondiente a la Linea N° ' . strval($this->rows + 1) . ' del archivo posee un nuevo beneficiario. <br>';
                                }   
                            }
                
                            //Log::info("Linea: " . strval($this->rows + 1) . " .El tramite N° " . $row['tramite_num_tramite_legacy'] . ", ha sido cargado previamente", ["Modulo" => "ImportPromocion:store", "Usuario" => Auth::user()->id . ": " . Auth::user()->name]);
                        } else {
    
                            $tramite = Tramite::where('num_tramite_legacy', $row['tramite_num_tramite_legacy'])->first();
                            if(!$tramite){
                                $tramite_data = Tramite::Create(
                                    [
                                        'fecha' => date("Y-m-d ", strtotime($row['tramite_fecha'])),
                                        'canal_atencion_id' => $row['tramite_canal_atencion_id'],
                                        'tipo_tramite_id' => $row['tramite_tipo_tramite_id'],
                                        'dependencia_id' => $row['tramite_dependencia_id'],
                                        'parentesco_id' => $row['tramite_parentesco_id'] !== 'NULL' && $row['tramite_parentesco_id'] !== -1 ? $row['tramite_parentesco_id'] : null,
                                        'estado_id' => $row['tramite_estado_id'],
                                        'observacion' => $row['tramite_observacion'] !== 'NULL' && $row['tramite_observacion'] !== -1 ? $row['tramite_observacion'] : '',
                                        'num_tramite_legacy' => $row['tramite_num_tramite_legacy']
                                    ]
                                );
                                $person->tramites()->attach($tramite_data['id'], ['rol_tramite_id' => 1]); // ROL TITULAR
                            }
                            ++$this->rowsSuccess;
                            //Log::info("Se ha importado correctamente el tramite N° ".$row['tramite_num_tramite_legacy']." , bajo el ID de Tramite N° ".$tramite_data['id'], ["Modulo" => "ImportPromocion:store", "Usuario" => Auth::user()->id . ": " . Auth::user()->name]);
                        }
                        DB::commit();
                    }else{
                        ++$this->rowsError;
                        $this->entidadesNoRegistradas .= ' - Tramite de la Linea N° ' . strval($this->rows + 1) . ' del archivo no se ha sido almacenar. Error: El titular no posee fecha de nacimiento<br>';
                    }
                } catch (\Throwable $th) {
                    dd($th);
                    DB::rollBack();
                    ++$this->rowsError;
                    $this->entidadesNoRegistradas .= ' - Tramite de la Linea N° ' . strval($this->rows + 1) . ' del archivo no se ha sido almacenar. Error: ' . $th->getMessage() . '<br>';
                    Log::error("Se ha generado un error al momento de almacenar el tramite de la linea N° " . $row['tramite_num_tramite_legacy'], ["Modulo" => "ImportNinez:store", "Usuario" => Auth::user()->id . ": " . Auth::user()->name, "Error" => $th->getMessage()]);
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

        Log::info("Importador de Tramite de Niñez, ejecutado por el usuario:  ".Auth::user()->id . ": " . Auth::user()->name."<br>=> ".$retorno);

        if ($this->registrosDuplidados != '') {
            $retorno .= '<br>Registros Duplicados<br>';
            $retorno .= '=====================================<br>';
            $retorno .= $this->registrosDuplidados;
        }

        return $retorno;
    }

    public function batchSize(): int
    {
        return 500;
    }

    public function chunkSize(): int
    {
        return 1000;
    }
}