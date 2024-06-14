<?php

namespace App\Imports;
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
use Mockery\Undefined;

class FortalecimientoImportTemplate implements ToModel, WithHeadingRow, WithBatchInserts, WithStartRow
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
        return 3;
    }


    public function model(array $row)
    {
        if (empty($row['nro'])) {
            return null;
        }
        
        ++$this->rows;  

        /* // Obtener encabezados
        $headings = array_keys($row);

        // Filtrar las columnas con encabezados vacíos
        $filteredRow = [];
        foreach ($headings as $heading) {
            if (!empty($heading) && isset($row[$heading])) {
                $filteredRow[$heading] = $row[$heading];
            }
        } */
        // Verificar si la fila está vacía
        
        try {
            $person = Person::updateOrCreate(
                [
                    'tipo_documento_id' => 1,
                    'num_documento' => $row['num_documento']
                ],
                [
                    'lastname' => strtoupper(str_replace(' ', '', $row['apellido'])) !== 'NULL' ? $row['apellido'] : null,
                    'name' => strtoupper(str_replace(' ', '', $row['nombre'])) !== 'NULL' ? $row['nombre'] : null,
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
                    'situacion_conyugal_id' => $row['situacion_conyugal'] !== 'NULL' ? $row['situacion_conyugal'] : null
                ]
            );

            SocialData::updateOrCreate(
                [
                    'person_id' => $person->id
                ],
                [
                    'tipo_ocupacion_id' => $row['ocupacion'] !== 'NULL' && $row['ocupacion'] !== -1 ? $row['ocupacion'] : null,
                    'cobertura_medica_id' => $row['cobertura_salud'] !== 'NULL' && $row['cobertura_salud'] !== -1 ? $row['cobertura_salud'] : null,
                    'tipo_pension_id' => $row['pension'] !== 'NULL' && $row['pension'] !== -1 ? $row['pension'] : null,
                ]
            );

            /* EducationData::updateOrCreate(
                [
                    'person_id' => $person->id
                ],
                [
                    'nivel_educativo_id' => $row['education_nivel_educativo_id'] !== 'NULL' && $row['education_nivel_educativo_id'] !== -1 ? $row['education_nivel_educativo_id'] : null,
                    'estado_educativo_id' => $row['education_estado_educativo_id'] !== 'NULL' && $row['education_estado_educativo_id'] !== -1 ? $row['education_estado_educativo_id'] : null
                ]
            ); */

            // address_data

            AddressData::updateOrCreate(
                [
                    'person_id' => $person->id
                ],
                [
                    'calle' => strtoupper(str_replace(' ', '', $row['calle'])) !== 'NULL' ? $row['calle'] : null,
                    'number' => strtoupper(str_replace(' ', '', $row['numero'])) !== 'NULL' ? $row['numero'] : null,
                    'piso' => strtoupper(str_replace(' ', '', $row['piso'])) !== 'NULL' ? $row['piso'] : null,
                    'dpto' => strtoupper(str_replace(' ', '', $row['dpto'])) !== 'NULL' ? $row['dpto'] : null,
                    'pais_id' => $row['nacionalidad'] !== 'NULL' && $row['nacionalidad'] !== -1 ? $row['nacionalidad'] : null,
                    'localidad_id' => $row['localidad'] !== 'NULL' && $row['localidad'] !== -1 ? $row['localidad'] : null,
                    'barrio_id' => $row['barrio'] !== 'NULL' ? $row['barrio'] : null

                ]
            );

            // contact_data

            ContactData::updateOrCreate(
                [
                    'person_id' => $person->id
                ],
                [
                    'phone' => strtoupper(str_replace(' ', '', $row['telefono'])) !== 'NULL' ? $row['telefono'] : null,
                    'email' => strtoupper(str_replace(' ', '', $row['celular'])) !== 'NULL' ? $row['celular'] : null
                ]
            );

            
                $tramite_data = Tramite::Create(
                    [
                        'fecha' => $this->transformDate($row['fecha'] ?? null),
                        'canal_atencion_id' => $row['canal_atencion'],
                        'tipo_tramite_id' => $row['tipo_tramite'],
                        'dependencia_id' => 5,
                        'estado_id' => 1
                    ]
                );
                $person->tramites()->attach($tramite_data['id'], ['rol_tramite_id' => 1]); // ROL TITULAR

                ++$this->rowsSuccess;
               // Log::info("Se ha importado correctamente el tramite N° ".$row['tramite_num_tramite_legacy']." , bajo el ID de Tramite N° ".$tramite_data['id'], ["Modulo" => "ImportFortalecimiento:store", "Usuario" => Auth::user()->id . ": " . Auth::user()->name]);
            
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            ++$this->rowsError;
            $this->entidadesNoRegistradas .= ' - Tramite de la Linea N° ' . strval($this->rows + 1) . ' del archivo no se ha sido almacenar. Error: ' . $th->getMessage() . '<br>';
            Log::error("Se ha generado un error al momento de almacenar el tramite de la linea N° " . strval($this->rows + 1), ["Modulo" => "ImportFortalecimiento:store", "Usuario" => Auth::user()->id . ": " . Auth::user()->name, "Error" => $th->getMessage()]);
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

    private function transformDate($value)
    {
        if (!is_numeric($value)) {
            return null;
        }

        // La fecha base de Excel es 30-12-1899
        return Carbon::parse('1899-12-30')->addDays($value)->format('Y-m-d');
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
