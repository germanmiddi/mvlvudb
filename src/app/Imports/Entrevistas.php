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
use App\PersonProgramaSocial;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithBatchInserts;

use Carbon\Carbon;

class Entrevistas implements ToModel, WithHeadingRow, WithBatchInserts
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
        if (empty($row['fecha'])) { 
            return null;
        }
        try {

            $person = Person::updateOrCreate(
                [
                    'tipo_documento_id' => $this->extractID($row['tipo_de_documento']),
                    'num_documento' => $row['nro_documento']
                ],
                array_filter([
                    'lastname' => !empty($row['apellido']) && strtoupper(str_replace(' ', '', $row['apellido'])) !== 'NULL' 
                        ? ucwords(strtolower(trim($row['apellido']))) 
                        : null,
                    'name' => !empty($row['nombre']) && strtoupper(str_replace(' ', '', $row['nombre'])) !== 'NULL' 
                        ? ucwords(strtolower(trim($row['nombre']))) 
                        : null,
                    'fecha_nac' => !empty($row['fecha_de_nacimiento']) 
                        ? $this->formatDate($row['fecha_de_nacimiento'])
                        : null
                ], fn($value) => $value !== null)
            );

            
            ContactData::updateOrCreate(
                [
                    'person_id' => $person->id
                ],
                [
                    'email' => strtoupper(str_replace(' ', '', $row['email'])) !== 'NULL' ? $row['email'] : null,
                    'phone' => strtoupper(str_replace(' ', '', $row['telefono'])) !== 'NULL' ? $row['telefono'] : null,
                    'celular' => strtoupper(str_replace(' ', '', $row['celular'])) !== 'NULL' ? $row['celular'] : null,
                    ]
                );

            AddressData::updateOrCreate(
                [
                    'person_id' => $person->id
                ],
                [
                    'localidad_id' => $row['localidad'] !== 'NULL' && $row['localidad'] !== -1 ? $this->extractIDLocalidades($row['localidad']) : null,
                    'barrio_id' => $row['barrio'] !== 'NULL' ? $this->extractID($row['barrio']) : null,
                    'calle' => strtoupper(str_replace(' ', '', $row['calle'])) !== 'NULL' ? $row['calle'] : null,
                    'number' => strtoupper(str_replace(' ', '', $row['numero'])) !== 'NULL' ? $row['numero'] : null,
                    'piso' => strtoupper(str_replace(' ', '', $row['piso'])) !== 'NULL' ? $row['piso'] : null,
                    'dpto' => strtoupper(str_replace(' ', '', $row['departamento'])) !== 'NULL' ? $row['departamento'] : null,
                ]
            );

            AditionalData::updateOrCreate(
                [
                    'person_id' => $person->id
                ],
                [
                    'cant_hijos' => $row['cant_de_hijos'],
                    'situacion_conyugal_id' => $row['situacion_conyugal'],
                    'nacionalidad' => $row['pais_de_origen'],
                ]
            );

            SocialData::updateOrCreate(
                [
                    'person_id' => $person->id
                ],
                [
                    'tipo_ocupacion_id' => $row['ocupacion'] !== 'NULL' && $row['social_tipo_ocupacion_id'] !== -1 ? $row['social_tipo_ocupacion_id'] : null,
                    'cobertura_medica_id' => $row['cobertura_salud'] !== 'NULL' && $row['social_cobertura_medica_id'] !== -1 ? $row['social_cobertura_medica_id'] : null,
                    'tipo_pension_id' => $row['recibe_pension'] !== 'NULL' && $row['social_tipo_pension_id'] !== -1 ? $row['social_tipo_pension_id'] : null,
                ]
            );

            PersonProgramaSocial::updateOrCreate(
                [
                    'person_id' => $person->id,
                    'programa_social' => $row['programa_social'],
                ],
                []
            );

            EducationData::updateOrCreate(
                [
                    'person_id' => $person->id
                ],
                [
                    'nivel_educativo_id' => $row['nivel_educativo_en_curso'] !== 'NULL' && $row['education_nivel_educativo_id'] !== -1 ? $row['education_nivel_educativo_id'] : null,
                    'estado_educativo_id' => $row['nivel_educativo_alcanzado'] !== 'NULL' && $row['education_estado_educativo_id'] !== -1 ? $row['education_estado_educativo_id'] : null
                ]
            );


            // if (Tramite::where('num_tramite_legacy', $row['tramite_num_tramite_legacy'])->first()) {
            //     $tramite_data = Tramite::where('num_tramite_legacy', $row['tramite_num_tramite_legacy'])->update(
            //         [
            //             'fecha' => date("Y-m-d ", strtotime($row['Fecha'])),
            //             'canal_atencion_id' => $row['Canal de Atencion'],
            //             'tipo_tramite_id' => $row['Tipo Tramite'],
            //             'dependencia_id' => $row['tramite_dependencia_id'] ?? 5,
            //             // 'parentesco_id' => $row['tramite_parentesco_id'] !== 'NULL' && $row['tramite_parentesco_id'] !== -1 ? $row['tramite_parentesco_id'] : null,
            //             // 'parentesco_id' => 1,
            //             'estado_id' => $row['Estado'],
            //             // 'num_tramite_legacy' => $row['tramite_num_tramite_legacy']
            //         ]
            //     );


            //     ++$this->rowsDuplicados;
            //     $this->registrosDuplidados .= ' - Tramite correspondiente a la Linea N° ' . strval($this->rows + 1) . ' del archivo ha sido cargado previamente. <br>';
            //Log::info("Linea: " . strval($this->rows + 1) . " .El tramite N° " . $row['tramite_num_tramite_legacy'] . ", ha sido cargado previamente", ["Modulo" => "ImportFortalecimiento:store", "Usuario" => Auth::user()->id . ": " . Auth::user()->name]);
            // } else {
            $tramite_data = Tramite::Create(
                [
                    'fecha' => $this->formatDate($row['fecha']),
                    'canal_atencion_id' => $this->extractID($row['canal_de_atencion']),
                    'tipo_tramite_id' => $row['tipo_tramite'],
                    'dependencia_id' => $row['tramite_dependencia_id'] ?? 5,
                    // 'parentesco_id' => $row['tramite_parentesco_id'] !== 'NULL' && $row['tramite_parentesco_id'] !== -1 ? $row['tramite_parentesco_id'] : null,
                    'estado_id' => $this->extractID($row['estado']),
                    // 'num_tramite_legacy' => $row['tramite_num_tramite_legacy']
                ]
            );
            $person->tramites()->attach($tramite_data['id'], ['rol_tramite_id' => 1]); // ROL TITULAR

            ++$this->rowsSuccess;
            // Log::info("Se ha importado correctamente el tramite N° ".$row['tramite_num_tramite_legacy']." , bajo el ID de Tramite N° ".$tramite_data['id'], ["Modulo" => "ImportFortalecimiento:store", "Usuario" => Auth::user()->id . ": " . Auth::user()->name]);
            // }
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            ++$this->rowsError;
            $this->entidadesNoRegistradas .= ' - Tramite de la Linea N° ' . strval($this->rows + 1) . ' del archivo no se ha sido almacenar. Error: ' . $th->getMessage() . '<br>';
            // Log::error("Se ha generado un error al momento de almacenar el tramite de la linea N° " . $row['tramite_num_tramite_legacy'], ["Modulo" => "ImportFortalecimiento:store", "Usuario" => Auth::user()->id . ": " . Auth::user()->name, "Error" => $th->getMessage()]);
        }
        return;
    }

    private function extractID($rowID)
    {
        if (empty($rowID)) {
            return null;
        }

        if (preg_match('/^\d+/', $rowID, $matches)) {
            return (int)$matches[0];
        } else{
            return null;
        }
    }

    private function extractIDLocalidades($value)
    {
        if (empty($value)) {
            return null;
        }

        if (preg_match('/_(\d+)$/', $value, $matches)) {
            return (int)$matches[1];
        } else {
            return null;
        }

    }

    private function formatDate($date)
    {
        if (empty($date)) {
            return null;
        }

        try {
            if (is_numeric($date)) {
                return \Carbon\Carbon::createFromFormat('Y-m-d', \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($date)->format('Y-m-d'));
            }
            return \Carbon\Carbon::parse($date)->format('Y-m-d');
        } catch (\Exception $e) {
            return null;
        }
    }

    // public function getStatus()
    // {
    //     $retorno = 'PROCESO DE IMPORTADOR DE TRAMITES FINALIZADO <br>';
    //     $retorno .= '=====================================<br>';
    //     $retorno .= 'Se han procesado un total de ' . strval($this->rows) . ' registros <br>';
    //     $retorno .= 'Se ha registrado un total de ' . strval($this->rowsSuccess) . ' registros correctamente <br>';
    //     $retorno .= 'Se ha registrado un total de ' . strval($this->rowsDuplicados) . ' registros duplicados <br>';
    //     $retorno .= 'Se ha registrado un total de ' . strval($this->rowsError) . ' registros con errores <br>';

    //     if ($this->entidadesNoRegistradas != '') {
    //         $retorno .= '<br>Registros con Errores<br>';
    //         $retorno .= '=====================================<br>';
    //         $retorno .= $this->entidadesNoRegistradas;
    //     }

    //     Log::info("Importador de Tramite de Fortalecimiento, ejecutado por el usuario:  " . Auth::user()->id . ": " . Auth::user()->name . "<br>=> " . $retorno);
    //     if ($this->registrosDuplidados != '') {
    //         $retorno .= '<br>Registros Duplicados<br>';
    //         $retorno .= '=====================================<br>';
    //         $retorno .= $this->registrosDuplidados;
    //     }

    //     return $retorno;
    // }

    public function batchSize(): int
    {
        return 1000;
    }
}