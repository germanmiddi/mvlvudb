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
        if (
            empty($row['nombre_completo'])
        ) {
            return null;
        }
        ++$this->rows;

        $fields = ['localidad_id', 'dependencia_id', 'nivel_educativo'];

        $localidadId = null;
        $dependenciaId = null;
        $nivelEducativoId = null;
        try {

            foreach ($fields as $field) {
                if (isset($row[$field])) {
                    switch ($field) {
                        case 'localidad_id':
                            $localidadId = $this->buscarIdPorDescripcion(Localidad::class, $row['localidad_id']);
                            break;
                        case 'dependencia_id':
                            $dependenciaId = $this->buscarIdPorDescripcion(EscuelaDependencia::class, $row['dependencia_id']);
                            break;
                        case 'nivel_educativo':
                            $nivelEducativoId = $this->buscarIdPorDescripcion(NivelEducativo::class, $row['nivel_educativo']);
                            break;
                    }
                }
            }

            $exist = EscuelaV2::where('nombre_completo', '=', $row['nombre_completo'])->exists();
            if ($exist) {
                ++$this->rows;
            } else {
                $escuela = EscuelaV2::create([
                    'numero_sigla' => $row['numero_sigla'],
                    'nombre_completo' => $row['nombre_completo'],
                    'localidad_id' => $localidadId ?? null,
                    'dependencia_id' => $dependenciaId ?? null,
                    'direccion' => $row['direccion'],
                    'telefono' => $row['telefono'],
                    'mail' => $row['mail'],
                    'activo' => 1
                ]);

                if (!is_null($nivelEducativoId)) {
                    $escuela->niveles()->attach($nivelEducativoId);
                }
                ++$this->rowsSuccess;

                Log::info("Se ha importado correctamente el tramite del registro NRO:  " . $row['nombre_completo'] . " , bajo el ID de Tramite N° " . $escuela['id'], ["Modulo" => "ImportFortalecimiento:template", "Usuario" => Auth::user()->id . ": " . Auth::user()->name]);
                DB::commit();
            }


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
            return $id !== null ? $id : null;
        } else {
            return $modelo::where('description', 'LIKE', "%$value%")->value('id');
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
