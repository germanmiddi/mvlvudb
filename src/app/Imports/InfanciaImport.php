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

class InfanciaImport implements ToModel,WithHeadingRow, WithBatchInserts
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

            /* AditionalData::updateOrCreate(
                [
                    'person_id' => $person->id
                ],
                [
                    'cant_hijos' => $row['aditional_cant_hijos'],
                    'situacion_conyugal_id' => $row['aditional_situacion_conyugal_id'] !== 'NULL' ? $row['aditional_situacion_conyugal_id'] : null
                ]
            ); */

            SocialData::updateOrCreate(
                [
                    'person_id' => $person->id
                ],
                [
                    'tipo_ocupacion_id' => $row['social_tipo_ocupacion_id'] !== 'NULL' && $row['social_tipo_ocupacion_id'] !== -1 ? $row['social_tipo_ocupacion_id'] : null,
                    //'cobertura_medica_id' => $row['social_cobertura_medica_id'] !== 'NULL' && $row['social_cobertura_medica_id'] !== -1 ? $row['social_cobertura_medica_id'] : null,
                ]
            );

            EducationData::updateOrCreate(
                [
                    'person_id' => $person->id
                ],
                [
                    'nivel_educativo_id' => $row['person_nivel_educativo_id'] !== 'NULL' && $row['person_nivel_educativo_id'] !== -1 ? $row['person_nivel_educativo_id'] : null,
                    'estado_educativo_id' => $row['person_estado_educativo_id'] !== 'NULL' && $row['person_estado_educativo_id'] !== -1 ? $row['person_estado_educativo_id'] : null
                ]
            );

            // address_data

            AddressData::updateOrCreate(
                [
                    'person_id' => $person->id
                ],
                [
                    'calle' => strtoupper(str_replace(' ', '', $row['person_address_calle'])) !== 'NULL' ? $row['person_address_calle'] : null,
                    /* 'number' => strtoupper(str_replace(' ', '', $row['address_number'])) !== 'NULL' ? $row['address_number'] : null,
                    'piso' => strtoupper(str_replace(' ', '', $row['address_piso'])) !== 'NULL' ? $row['address_piso'] : null,
                    'dpto' => strtoupper(str_replace(' ', '', $row['address_dpto'])) !== 'NULL' ? $row['address_dpto'] : null, */
                    'pais_id' => $row['person_address_pais_id'] !== 'NULL' && $row['person_address_pais_id'] !== -1 ? $row['person_address_pais_id'] : null,
                    'localidad_id' => $row['person_address_localidad_id'] !== 'NULL' && $row['person_address_localidad_id'] !== -1 ? $row['person_address_localidad_id'] : null,
                    //'barrio_id' => $row['address_barrio_id'] !== 'NULL' ? $row['address_barrio_id'] : null

                ]
            );

            // contact_data

            ContactData::updateOrCreate(
                [
                    'person_id' => $person->id
                ],
                [
                    'phone' => strtoupper(str_replace(' ', '', $row['contact_phone'])) !== 'NULL' ? $row['contact_phone'] : null,
                    'celular' => strtoupper(str_replace(' ', '', $row['contact_celular'])) !== 'NULL' ? $row['contact_celular'] : null
                ]
            );


            /* NIÑO  */

            $nino = Person::updateOrCreate(
                [
                    'tipo_documento_id' => $row['nino_tipo_documento_id'],
                    'num_documento' => $row['nino_num_documento']
                ],
                [
                    'lastname' => strtoupper(str_replace(' ', '', $row['nino_name'])) !== 'NULL' ? $row['nino_name'] : null,
                    'name' => strtoupper(str_replace(' ', '', $row['nino_name'])) !== 'NULL' ? $row['nino_name'] : null,
                    'fecha_nac' => $row['nino_fecha_nac'],
                    'tipo_documento_id' => $row['nino_tipo_documento_id'],
                    'num_documento' => $row['nino_num_documento']
                ]
            );

            EducationData::updateOrCreate(
                [
                    'person_id' => $nino->id
                ],
                [
                    'nivel_educativo_id' => $row['nino_nivel_educativo_id'] !== 'NULL' && $row['nino_nivel_educativo_id'] !== -1 ? $row['nino_nivel_educativo_id'] : null,
                    //'estado_educativo_id' => $row['person_address_pais_id'] !== 'NULL' && $row['person_address_pais_id'] !== -1 ? $row['person_address_pais_id'] : null,
                    'escuela_id' => $row['nino_escuela_id'] !== 'NULL' && $row['nino_escuela_id'] !== -1 ? $row['nino_escuela_id'] : null,
                   // 'escuela_infante_id' => $row['person_address_pais_id'] !== 'NULL' && $row['person_address_pais_id'] !== -1 ? $row['person_address_pais_id'] : null,
                    'escuela_dependencia_id' => $row['nino_escuela_dependencia_id'] !== 'NULL' && $row['nino_escuela_dependencia_id'] !== -1 ? $row['nino_escuela_dependencia_id'] : null,
                    'escuela_localidad_id' => $row['nino_escuela_localidad_id'] !== 'NULL' && $row['nino_escuela_localidad_id'] !== -1 ? $row['nino_escuela_localidad_id'] : null,
                    'escuela_nivel_id' => $row['nino_escuela_nivel_id'] !== 'NULL' && $row['nino_escuela_nivel_id'] !== -1 ? $row['nino_escuela_nivel_id'] : null,
                    'escuela_turno_id' => $row['nino_escuela_turno_id'] !== 'NULL' && $row['nino_escuela_turno_id'] !== -1 ? $row['nino_escuela_turno_id'] : null,
                    'permanencia' => $row['nino_permanencia'] == 'SI' ? 1 : ($row['nino_permanencia'] == 'NO' ? 0 : null),
                    'certificado_escolar' => $row['nino_certificado_escolar'] == 'SI' ? 1 : ($row['nino_certificado_escolar'] == 'NO' ? 0 : null),
                   // 'observacion' => $row['person_address_pais_id'] !== 'NULL' && $row['person_address_pais_id'] !== -1 ? $row['person_address_pais_id'] : null,
                ]
            );

            // address_data

            AddressData::updateOrCreate(
                [
                    'person_id' => $nino->id
                ],
                [
                    'calle' => $row['nino_calle'] !== 'NULL' && $row['nino_calle'] !== -1 ? $row['nino_calle'] : null,
                   // 'number' => $request['nino_number'],
                   // 'piso' => $request['nino_piso'],
                   // 'dpto' => $request['nino_dpto'],
                   // 'latitude' => $request['nino_latitude'],
                   // 'longitude' => $request['nino_longitude'],
                   // 'google_address' => $request['nino_google_address'],
                   // 'pais_id' => $request['nino_pais_id'],
                   /// 'localidad_id' => $request['nino_localidad_id'],
                    'barrio_id' => $row['nino_barrio_id'] !== 'NULL' && $row['nino_barrio_id'] !== -1 ? $row['nino_barrio_id'] : null,

                ]
            );

            // contact_data

            ContactData::updateOrCreate(
                [
                    'person_id' => $nino->id
                ],
                [
                    //'phone' => $request['nino_phone'],
                   // 'celular' => $request['nino_celular'],
                   // 'email' => $request['nino_email']
                ]
            );

            // salud_data

            SaludData::updateOrCreate(
                [
                    'person_id' => $nino->id
                ],
                [
                    'apto_medico' => $row['nino_apto_medico'] == 'SI' ? 1 : ($row['nino_apto_medico'] == 'NO' ? 0 : null),
                    'libreta_vacunacion' => $row['nino_libreta_vacunacion'] == 'SI' ? 1 : ($row['nino_libreta_vacunacion'] == 'NO' ? 0 : null),
                 //  'observacion' => $request['nino_observacion'],
                    'centro_salud_id' =>$row['nino_centro_salud_id'] !== 'NULL' && $row['nino_centro_salud_id'] !== -1 ? $row['nino_centro_salud_id'] : null,
                    'estado_salud_id' => $row['nino_estado_salud_id'] !== 'NULL' && $row['nino_estado_salud_id'] !== -1 ? $row['nino_estado_salud_id'] : null,
                   // 'observacion' => $request['nino_observacion_salud'],
                ]
            );

             // tramite
             $tramite_data = Tramite::Create(
                [
                    'fecha' => date("Y-m-d ", strtotime($row['tramite_fecha'])),
                    'canal_atencion_id' => 1,
                    'tipo_tramite_id' => $row['tramite_tipo_tramite_id'],
                    'dependencia_id' => 12,
                    'parentesco_id' => $row['tramite_parentesco_id'] !== 'NULL' && $row['tramite_parentesco_id'] !== -1 ? $row['tramite_parentesco_id'] : null,
                    //'estado_id' => $row['tramite_estado_id'],
                    //'num_tramite_legacy' => $row['tramite_num_tramite_legacy']
                ]
            );

            CbiData::Create(
                [
                    'anio_inicio' => $row['anio_inicio'] !== 'NULL' && $row['anio_inicio'] !== -1 ? $row['anio_inicio'] : null,
                    'aut_firmada' => $row['aut_firmada'] == 'SI' ? 1 : ($row['aut_firmada'] == 'NO' ? 0 : null),
                    'aut_retirarse' => $row['aut_retirarse'] == 'SI' ? 1 : ($row['aut_retirarse'] == 'NO' ? 0 : null),
                    'aut_uso_imagen' => $row['aut_uso_imagen'] == 'SI' ? 1 : ($row['aut_uso_imagen'] == 'NO' ? 0 : null),
                    //'act_varias' => $request['act_varias'],
                    //'act_esporadicas' => $request['act_esporadicas'],
                    //'comedor' => $request['comedor'],
                    //'estado_cbi_id' => $request['estado_cbi_id'],
                    //'estado_gabinete_id'  => $request['estado_gabinete_id'],
                    //'tramite_id' => $tramite_data['id']
                ]
            );


            ++$this->rowsSuccess;

            /* if (Tramite::where('num_tramite_legacy', $row['tramite_num_tramite_legacy'])->first()) {
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
                //Log::info("Linea: " . strval($this->rows + 1) . " .El tramite N° " . $row['tramite_num_tramite_legacy'] . ", ha sido cargado previamente", ["Modulo" => "ImportMayores:store", "Usuario" => Auth::user()->id . ": " . Auth::user()->name]);
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
                //Log::info("Se ha importado correctamente el tramite N° ".$row['tramite_num_tramite_legacy']." , bajo el ID de Tramite N° ".$tramite_data['id'], ["Modulo" => "ImportMayores:store", "Usuario" => Auth::user()->id . ": " . Auth::user()->name]);
            } */
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            ++$this->rowsError;
            $this->entidadesNoRegistradas .= ' - Tramite de la Linea N° ' . strval($this->rows + 1) . ' del archivo no se ha sido almacenar. Error: ' . $th->getMessage() . '<br>';
            Log::error("Se ha generado un error al momento de almacenar el tramite de la linea N° " . $row['tramite_num_tramite_legacy'], ["Modulo" => "JuventudImport:store", "Usuario" => Auth::user()->id . ": " . Auth::user()->name, "Error" => $th->getMessage()]);
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
