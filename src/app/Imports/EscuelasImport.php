<?php

namespace App\Imports;
use App\Models\Manager\EscuelaDependencia;
use App\Models\Manager\Localidad;
use App\Models\Manager\NivelEducativo;
use Carbon\Carbon;

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
use Maatwebsite\Excel\Concerns\WithStartRow;
use App\Models\Manager\EscuelaV2;
use Mockery\Undefined;

class EscuelasImport implements ToModel, WithHeadingRow, WithBatchInserts, WithStartRow
{
    private $rows = 0;
    private $rowsSuccess = 0;
    private $rowsError = 0;
    private $rowsDuplicados = 0;
    private $entidadesNoRegistradas = '';
    private $registrosDuplidados = '';

    /**
     * Define el número de fila desde donde comenzar la importación.
     *
     * @return int
     */
    public function startRow(): int
    {
        return 2;
    }


    public function model(array $row)
    {
        if (empty($row['nro'])) {
            return null;
        }
        ++$this->rows;
        
        $fields = ['localidad_id', 'dependencia_id', 'nivel_educativo'];
        try {

            // foreach($fields as $field){
            //     if(isset($row[$field])){
            //         switch ($field) {
            //             case 'localidad_id':
            //                 $localidadId = $this->buscarIdPorDescripcion(Localidad::class, $row['localidad_id']);
            //                 break;
            //             case 'dependencia_id':
            //                 $dependenciaId = $this->buscarIdPorDescripcion(EscuelaDependencia::class, $row['dependencia_id']);
            //                 break;
            //             case 'nivel_educativo':
            //                 $nivelEducativoId = $this->buscarIdPorDescripcion(NivelEducativo::class, $row['nivel_educativo']);
            //                 break;
            //         }
            //     }
            // }
            

            EscuelaV2::create([
                'numero/sigla' => $this->transformDate($row['numero/sigla'] ?? null),
                'nombre_completo' => $row['nombre_completo'],
                'localidad_id' => $localidadId,
                'dependencia_id' => $dependenciaId,
                'direccion' => $row['direccion'],
                'telefono' => $row['telefono'],
                'mail' => $row['mail'],
                'activo' => 1
            ]);

















            $person = Person::updateOrCreate(
                [
                    'tipo_documento_id' => 1,
                    'num_documento' => $row['num_documento']
                ],
                [
                    'lastname' => $row['apellido'] !== '' ? $row['apellido'] : null,
                    'name' => $row['nombre'] !== '' ? $row['nombre'] : null,
                    'fecha_nac' => $this->transformDate($row['fecha_nac'] ?? null),
                    'tipo_documento_id' => 1,
                    'num_documento' => $row['num_documento']
                ]
            );

            AditionalData::updateOrCreate(
                [
                    'person_id' => $person->id
                ],
                [
                    'cant_hijos' => $row['cantidad_hijos'],
                    'situacion_conyugal_id' => $row['situacion_conyugal'] !== '' ? $row['situacion_conyugal'] : null
                ]
            );

            SocialData::updateOrCreate(
                [
                    'person_id' => $person->id
                ],
                [
                    'tipo_ocupacion_id' => $row['ocupacion'] !== '' ? $row['ocupacion'] : null,
                    'cobertura_medica_id' => $row['cobertura_salud'] !== '' ? $row['cobertura_salud'] : null,
                    'tipo_pension_id' => $row['pension'] !== '' ? $row['pension'] : null,
                ]
            );

            EducationData::updateOrCreate(
                [
                    'person_id' => $person->id
                ],
                [
                    'nivel_educativo_id' => $row['nivel_educativo'] !== '' ? $row['nivel_educativo'] : null,
                    'estado_educativo_id' => $row['estado_educativo'] !== '' ? $row['estado_educativo'] : null
                ]
            );

            AddressData::updateOrCreate(
                [
                    'person_id' => $person->id
                ],
                [
                    'calle' => $row['calle'] !== '' ? $row['calle'] : null,
                    'number' => $row['numero'] !== '' ? $row['numero'] : null,
                    'piso' => $row['piso'] !== '' ? $row['piso'] : null,
                    'dpto' => $row['dpto'] !== '' ? $row['dpto'] : null,
                    'pais_id' => $row['nacionalidad'] !== '' ? $row['nacionalidad'] : null,
                    'localidad_id' => $row['localidad'] !== '' ? $row['localidad'] : null,
                    'barrio_id' => $row['barrio'] !== '' ? $row['barrio'] : null

                ]
            );

            ContactData::updateOrCreate(
                [
                    'person_id' => $person->id
                ],
                [
                    'phone' => $row['telefono'] !== '' ? $row['telefono'] : null,
                    'celular' => $row['celular'] !== '' ? $row['celular'] : null,
                    'email' => $row['email'] !== '' ? $row['email'] : null
                ]
            );

            $tramite_data = Tramite::Create(
                [
                    'fecha' => $this->transformDate($row['fecha'] ?? null),
                    'canal_atencion_id' => $row['canal_atencion'],
                    'tipo_tramite_id' => $row['tipo_tramite'],
                    'observacion' => $row['observacion'],
                    'dependencia_id' => 5,
                    'estado_id' => 1
                ]
            );
            $person->tramites()->attach($tramite_data['id'], ['rol_tramite_id' => 1]); // ROL TITULAR

            ++$this->rowsSuccess;

            Log::info("Se ha importado correctamente el tramite del registro NRO:  " . $row['nro'] . " , bajo el ID de Tramite N° " . $tramite_data['id'], ["Modulo" => "ImportFortalecimiento:template", "Usuario" => Auth::user()->id . ": " . Auth::user()->name]);

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            ++$this->rowsError;
            $this->entidadesNoRegistradas .= ' - Tramite de la Linea N° ' . strval($this->rows + 1) . ' del archivo no se ha sido almacenar. Error: ' . $th->getMessage() . '<br>';
            Log::error("Se ha generado un error al momento de almacenar el tramite de la linea N° " . strval($this->rows + 1), ["Modulo" => "ImportFortalecimiento:template", "Usuario" => Auth::user()->id . ": " . Auth::user()->name, "Error" => $th->getMessage()]);
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

        Log::info("Importador de Tramite de Fortalecimiento, ejecutado por el usuario:  " . Auth::user()->id . ": " . Auth::user()->name . "<br>=> " . $retorno);
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

    private function transformDate($value)
    {
        if (!is_numeric($value)) {
            return null;
        }

        // La fecha base de Excel es 30-12-1899
        return Carbon::parse('1899-12-30')->addDays($value)->format('Y-m-d');
    }

    private function buscarIdPorDescripcion($modelo, $value)
    {
        if (is_numeric($value)) {
            $id = $modelo::where('id', '=', $value)->value('id');
            $id != null ? return $id : null;
        }else{
            return $modelo::where('description', 'LIKE', "%$value%")->value('id') ?? $value;
        }

    }

    private function isRowEmpty(array $row)
    {
        foreach ($row as $cell) {
            if (!is_null($cell) && trim($cell) !== '') {
                return false;
            }
        }
        return true;
    }
}
