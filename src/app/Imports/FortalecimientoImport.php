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

class FortalecimientoImport implements ToModel, WithHeadingRow, WithBatchInserts
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
        try {
            $person = Person::updateOrCreate(
                [
                    'tipo_documento_id' => $row['person_tipo_documento_id'],
                    'num_documento' => $row['person_num_documento']
                ],
                [
                    'lastname' => strtoupper(str_replace(' ', '', $row['person_lastname'])) !== 'NULL' ? $row['person_lastname'] : null,
                    'name' => strtoupper(str_replace(' ', '', $row['person_name'])) !== 'NULL' ? $row['person_name'] : null,
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
                    'situacion_conyugal_id' => $row['aditional_situacion_conyugal_id'] !== 'NULL' ? $row['aditional_situacion_conyugal_id'] : null
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
                    'calle' => strtoupper(str_replace(' ', '', $row['address_calle'])) !== 'NULL' ? $row['address_calle'] : null,
                    'number' => strtoupper(str_replace(' ', '', $row['address_number'])) !== 'NULL' ? $row['address_number'] : null,
                    'piso' => strtoupper(str_replace(' ', '', $row['address_piso'])) !== 'NULL' ? $row['address_piso'] : null,
                    'dpto' => strtoupper(str_replace(' ', '', $row['address_dpto'])) !== 'NULL' ? $row['address_dpto'] : null,
                    'latitude' => strtoupper(str_replace(' ', '', $row['address_latitude'])) !== 'NULL' ? $row['address_latitude'] : null,
                    'longitude' => strtoupper(str_replace(' ', '', $row['address_longitude'])) !== 'NULL' ? $row['address_longitude'] : null,
                    'google_address' => strtoupper(str_replace(' ', '', $row['address_google_address'])) !== 'NULL' ? $row['address_google_address'] : null,
                    'pais_id' => $row['address_pais_id'] !== 'NULL' && $row['address_pais_id'] !== -1 ? $row['address_pais_id'] : null,
                    'localidad_id' => $row['address_localidad_id'] !== 'NULL' && $row['address_localidad_id'] !== -1 ? $row['address_localidad_id'] : null,
                    'barrio_id' => $row['address_barrio_id'] !== 'NULL' ? $row['address_barrio_id'] : null

                ]
            );

            // contact_data

            ContactData::updateOrCreate(
                [
                    'person_id' => $person->id
                ],
                [
                    'phone' => strtoupper(str_replace(' ', '', $row['contact_phone'])) !== 'NULL' ? $row['contact_phone'] : null,
                    'email' => strtoupper(str_replace(' ', '', $row['contact_email'])) !== 'NULL' ? $row['contact_email'] : null
                ]
            );

            if (Tramite::where('num_tramite_legacy', $row['tramite_num_tramite_legacy'])->first()) {
                $tramite_data = Tramite::where('num_tramite_legacy', $row['tramite_num_tramite_legacy'])->update(
                    [
                        'fecha' => date("Y-m-d ", strtotime($row['tramite_fecha'])),
                        'canal_atencion_id' => $row['tramite_canal_atencion_id'],
                        'tipo_tramite_id' => $row['tramite_tipo_tramite_id'],
                        'dependencia_id' => $row['tramite_dependencia_id'],
                        'parentesco_id' => $row['tramite_parentesco_id'] !== 'NULL' && $row['tramite_parentesco_id'] !== -1 ? $row['tramite_parentesco_id'] : null,
                        'estado_id' => $row['tramite_estado_id'],
                        'num_tramite_legacy' => $row['tramite_num_tramite_legacy']
                    ]
                );


                ++$this->rowsDuplicados;
                $this->registrosDuplidados .= ' - Tramite correspondiente a la Linea N° ' . strval($this->rows + 1) . ' del archivo ha sido cargado previamente. <br>';
                //Log::info("Linea: " . strval($this->rows + 1) . " .El tramite N° " . $row['tramite_num_tramite_legacy'] . ", ha sido cargado previamente", ["Modulo" => "ImportFortalecimiento:store", "Usuario" => Auth::user()->id . ": " . Auth::user()->name]);
            } else {
                $tramite_data = Tramite::Create(
                    [
                        'fecha' => date("Y-m-d ", strtotime($row['tramite_fecha'])),
                        'canal_atencion_id' => $row['tramite_canal_atencion_id'],
                        'tipo_tramite_id' => $row['tramite_tipo_tramite_id'],
                        'dependencia_id' => $row['tramite_dependencia_id'],
                        'parentesco_id' => $row['tramite_parentesco_id'] !== 'NULL' && $row['tramite_parentesco_id'] !== -1 ? $row['tramite_parentesco_id'] : null,
                        'estado_id' => $row['tramite_estado_id'],
                        'num_tramite_legacy' => $row['tramite_num_tramite_legacy']
                    ]
                );
                $person->tramites()->attach($tramite_data['id'], ['rol_tramite_id' => 1]); // ROL TITULAR

                ++$this->rowsSuccess;
               // Log::info("Se ha importado correctamente el tramite N° ".$row['tramite_num_tramite_legacy']." , bajo el ID de Tramite N° ".$tramite_data['id'], ["Modulo" => "ImportFortalecimiento:store", "Usuario" => Auth::user()->id . ": " . Auth::user()->name]);
            }
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            ++$this->rowsError;
            $this->entidadesNoRegistradas .= ' - Tramite de la Linea N° ' . strval($this->rows + 1) . ' del archivo no se ha sido almacenar. Error: ' . $th->getMessage() . '<br>';
            Log::error("Se ha generado un error al momento de almacenar el tramite de la linea N° " . $row['tramite_num_tramite_legacy'], ["Modulo" => "ImportFortalecimiento:store", "Usuario" => Auth::user()->id . ": " . Auth::user()->name, "Error" => $th->getMessage()]);
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

        Log::info("Importador de Tramite de Fortalecimiento, ejecutado por el usuario:  ".Auth::user()->id . ": " . Auth::user()->name."<br>=> ".$retorno);
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
