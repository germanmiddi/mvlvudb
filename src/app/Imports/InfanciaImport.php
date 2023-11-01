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
            if(strlen($row['anio_inicio']) > 4){
                $row['anio_inicio'] = date("Y", strtotime($row['anio_inicio']));
            }
            
            $row['nino_escuela_localidad_id'] = isset($row['nino_escuela_localidad_id']) ? $row['nino_escuela_localidad_id'] : null;
            $row['person_address_localidad_id'] = isset($row['person_address_localidad_id']) ? $row['person_address_localidad_id'] : null;
            $row['act_varias'] = isset($row['act_varias']) ? $row['act_varias'] : null;
            $row['escuela_infante_id'] = isset($row['escuela_infante_id']) ? $row['escuela_infante_id'] : null;
            $row['nino_localidad_id'] = isset($row['nino_localidad_id']) ? $row['nino_localidad_id'] : null;
            $person = Person::updateOrCreate(
                [
                    'tipo_documento_id' => $row['person_tipo_documento_id'],
                    'num_documento' => $row['person_num_documento']
                ],
                [
                    'lastname' => strtoupper(str_replace(' ', '', $row['person_lastname'])) !== 'NULL' && strtoupper(str_replace(' ', '', $row['person_lastname'])) !== null ? $row['person_lastname'] : null,
                    'name' => strtoupper(str_replace(' ', '', $row['person_name'])) !== 'NULL' && strtoupper(str_replace(' ', '', $row['person_name'])) !== ''  ? $row['person_name'] : null,
                    'fecha_nac' => date("Y-m-d ", strtotime($row['person_fecha_nac'])),
                    'tipo_documento_id' => $row['person_tipo_documento_id'],
                    'num_documento' => $row['person_num_documento']
                ]
            );

            SocialData::updateOrCreate(
                [
                    'person_id' => $person->id
                ],
                [
                    'tipo_ocupacion_id' => $row['social_tipo_ocupacion_id'] !== 'NULL' && $row['social_tipo_ocupacion_id'] !== -1 ? $row['social_tipo_ocupacion_id'] : null,
                    'programa_social_id' => $row['programa_social_id'] !== 'NULL' && $row['programa_social_id'] !== -1 ? $row['programa_social_id'] : null,
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

        
            AddressData::updateOrCreate(
                [
                    'person_id' => $person->id
                ],
                [
                    'calle' => strtoupper(str_replace(' ', '', $row['person_address_calle'])) !== 'NULL' ? $row['person_address_calle'] : null,
                    'pais_id' => $row['person_address_pais_id'] !== 'NULL' && $row['person_address_pais_id'] !== -1 ? $row['person_address_pais_id'] : null,
                    'localidad_id' => $row['person_address_localidad_id'] !== 'NULL' && $row['person_address_localidad_id'] !== -1 ? $row['person_address_localidad_id'] : null,

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
                    'lastname' => strtoupper(str_replace(' ', '', $row['nino_lastname'])) !== 'NULL' ? $row['nino_lastname'] : null,
                    'name' => strtoupper(str_replace(' ', '', $row['nino_name'])) !== 'NULL' ? $row['nino_name'] : null,
                    'fecha_nac' => date("Y-m-d ", strtotime($row['nino_fecha_nac'])),
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
                    'escuela_id' => $row['nino_escuela_id'] !== 'NULL' && $row['nino_escuela_id'] !== -1 ? $row['nino_escuela_id'] : null,
                    'escuela_infante_id' => $row['escuela_infante_id'] !== 'NULL' && $row['escuela_infante_id'] !== -1 ? $row['escuela_infante_id'] : null,
                    'escuela_dependencia_id' => $row['nino_escuela_dependencia_id'] !== 'NULL' && $row['nino_escuela_dependencia_id'] !== -1 ? $row['nino_escuela_dependencia_id'] : null,
                    'escuela_localidad_id' => $row['nino_escuela_localidad_id'] !== 'NULL' && $row['nino_escuela_localidad_id'] !== -1 ? $row['nino_escuela_localidad_id'] : null,
                    'escuela_nivel_id' => $row['nino_escuela_nivel_id'] !== 'NULL' && $row['nino_escuela_nivel_id'] !== -1 ? $row['nino_escuela_nivel_id'] : null,
                    'escuela_turno_id' => $row['nino_escuela_turno_id'] !== 'NULL' && $row['nino_escuela_turno_id'] !== -1 ? $row['nino_escuela_turno_id'] : null,
                    'permanencia' => $row['nino_permanencia'] == 'SI' ? 1 : ($row['nino_permanencia'] == 'NO' ? 0 : null),
                    'certificado_escolar' => $row['nino_certificado_escolar'] == 'SI' ? 1 : ($row['nino_certificado_escolar'] == 'NO' ? 0 : null),
                ]
            );

            // address_data

            AddressData::updateOrCreate(
                [
                    'person_id' => $nino->id
                ],
                [
                    'calle' => $row['nino_calle'] !== 'NULL' && $row['nino_calle'] !== -1 ? $row['nino_calle'] : null,
                    'localidad_id' => $row['nino_localidad_id'] !== 'NULL' && $row['nino_localidad_id'] !== -1 ? $row['nino_localidad_id'] : null,
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
                    'centro_salud_id' =>$row['nino_centro_salud_id'] !== 'NULL' && $row['nino_centro_salud_id'] !== -1 ? $row['nino_centro_salud_id'] : null,
                    'estado_salud_id' => $row['nino_estado_salud_id'] !== 'NULL' && $row['nino_estado_salud_id'] !== -1 ? $row['nino_estado_salud_id'] : null,
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
                    'sede_id' => $row['sede_id'],
                    'estado_id' => 1,
                ]
            );


            CbiData::Create(
                [
                    'anio_inicio' => $row['anio_inicio'] !== 'NULL' && $row['anio_inicio'] !== -1 ? $row['anio_inicio'] : null,
                    'aut_firmada' => $row['aut_firmada'] == 'SI' ? 1 : ($row['aut_firmada'] == 'NO' ? 0 : null),
                    'aut_retirarse' => $row['aut_retirarse'] == 'SI' ? 1 : ($row['aut_retirarse'] == 'NO' ? 0 : null),
                    'aut_uso_imagen' => $row['aut_uso_imagen'] == 'SI' ? 1 : ($row['aut_uso_imagen'] == 'NO' ? 0 : null),
                    'act_varias' => $row['act_varias'] == 'PRESENTE' ? 1 : ($row['act_varias'] == 'AUSENTE' ? 0 : null),
                    //'act_esporadicas' => $request['act_esporadicas'],
                    'comedor' => $row['comedor'] == 'SI' ? 1 : ($row['comedor'] == 'NO' ? 0 : null),
                    'estado_cbi_id' => $row['estado_cbi_id'] !== 'NULL' && $row['estado_cbi_id'] !== -1 ? $row['estado_cbi_id'] : null,
                    'estado_gabinete_id'  => $row['estado_gabinete_id'] !== 'NULL' && $row['estado_gabinete_id'] !== -1 ? $row['estado_gabinete_id'] : null,
                    'tramite_id' => $tramite_data['id']
                ]
            );

            $person->tramites()->attach($tramite_data['id'], ['rol_tramite_id' => 1]); // ROL TITULAR
                    
            $nino->tramites()->attach($tramite_data['id'], ['rol_tramite_id' => 2]); // ROL BENEFICIARIO


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
