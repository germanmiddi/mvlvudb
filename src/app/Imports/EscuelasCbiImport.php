<?php

namespace App\Imports;

use App\Models\Manager\Escuela;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithStartRow;

class EscuelasCbiImport implements ToModel, WithHeadingRow, WithBatchInserts, WithStartRow
{
    private $rows = 0;
    private $rowsSuccess = 0;
    private $rowsError = 0;
    private $rowsUpdated = 0;
    private $rowsCreated = 0;
    private $errorDetails = '';
    private $dependencia_id;

    public function __construct($dependencia_id = null)
    {
        $this->dependencia_id = $dependencia_id;
    }

    /**
     * Define el número de fila desde donde comenzar la importación.
     */
    public function startRow(): int
    {
        return 2;
    }

    public function model(array $row)
    {
        // Log para debug - ver qué columnas están llegando
        Log::info("Fila recibida en importación: ", $row);

        // Buscar el campo descripción en diferentes variaciones
        $descripcion = $this->getFieldValue($row, ['descripcion', 'description', 'nombre', 'escuela', 'nombre_escuela']);

        // Si no hay descripción, saltar esta fila
        if (empty($descripcion)) {
            Log::info("Fila saltada - sin descripción válida", $row);
            return null;
        }

        ++$this->rows;

        try {
            DB::beginTransaction();

            // Verificar si tiene ID para actualizar o crear nuevo
            $escuela = null;
            $isUpdate = false;

            if (!empty($row['id']) && is_numeric($row['id'])) {
                // Buscar escuela existente para actualizar
                $escuela = Escuela::find($row['id']);
                if ($escuela) {
                    $isUpdate = true;
                }
            }

            // Convertir valores booleanos usando campos flexibles
            $infante = $this->parseBooleanValue($this->getFieldValue($row, ['infante', 'jardin', 'jardin_infantes']));
            $primaria = $this->parseBooleanValue($this->getFieldValue($row, ['primaria', 'primario']));
            $secundaria = $this->parseBooleanValue($this->getFieldValue($row, ['secundaria', 'secundario']));
            $nocturna = $this->parseBooleanValue($this->getFieldValue($row, ['nocturna', 'nocturno']));
            $activo = $this->parseBooleanValue($this->getFieldValue($row, ['activo', 'active', 'habilitado']) ?? true);

            $data = [
                'description' => $descripcion,
                'dependencia_id' => $this->dependencia_id ?? $this->getFieldValue($row, ['dependencia_id', 'dependencia']) ?? null,
                'infante' => $infante,
                'primaria' => $primaria,
                'secundaria' => $secundaria,
                'nocturna' => $nocturna,
                'activo' => $activo,
                'updated_at' => Carbon::now()
            ];

            if ($isUpdate) {
                // Actualizar escuela existente
                $escuela->update($data);
                ++$this->rowsUpdated;
                Log::info("Escuela actualizada: ID {$escuela->id} - {$escuela->description}", [
                    "Modulo" => "ImportEscuelasCbi",
                    "Usuario" => Auth::user()->id . ": " . Auth::user()->name
                ]);
            } else {
                // Crear nueva escuela
                $data['created_at'] = Carbon::now();
                $escuela = Escuela::create($data);
                ++$this->rowsCreated;
                Log::info("Escuela creada: ID {$escuela->id} - {$escuela->description}", [
                    "Modulo" => "ImportEscuelasCbi",
                    "Usuario" => Auth::user()->id . ": " . Auth::user()->name
                ]);
            }

            ++$this->rowsSuccess;
            DB::commit();

        } catch (\Throwable $th) {
            DB::rollBack();
            ++$this->rowsError;
            $errorMsg = "Error en fila " . ($this->rows + 1) . ": " . $th->getMessage();
            $this->errorDetails .= "- {$errorMsg}<br>";

            Log::error("Error al importar escuela en fila " . ($this->rows + 1), [
                "Modulo" => "ImportEscuelasCbi",
                "Usuario" => Auth::user()->id . ": " . Auth::user()->name,
                "Error" => $th->getMessage(),
                "Fila" => $row
            ]);
        }

        return null;
    }

    /**
     * Convierte diferentes representaciones de booleanos a true/false
     */
    private function parseBooleanValue($value)
    {
        if (is_null($value) || $value === '') {
            return false;
        }

        // Convertir a string y limpiar
        $value = trim(strtolower(strval($value)));

        // Valores que se consideran true
        $trueValues = ['si', 'sí', 'yes', 'true', '1', 'verdadero', 'v'];

        // Valores que se consideran false
        $falseValues = ['no', 'false', '0', 'falso', 'f'];

        if (in_array($value, $trueValues)) {
            return true;
        }

        if (in_array($value, $falseValues)) {
            return false;
        }

        // Si no coincide con ningún patrón conocido, asumir false
        return false;
    }

    public function getStatus()
    {
        $retorno = 'PROCESO DE IMPORTACIÓN DE ESCUELAS FINALIZADO<br>';
        $retorno .= '===============================================<br>';
        $retorno .= 'Se han procesado un total de ' . $this->rows . ' registros<br>';
        $retorno .= 'Se han procesado exitosamente ' . $this->rowsSuccess . ' registros<br>';
        $retorno .= 'Se han creado ' . $this->rowsCreated . ' escuelas nuevas<br>';
        $retorno .= 'Se han actualizado ' . $this->rowsUpdated . ' escuelas existentes<br>';
        $retorno .= 'Se han registrado ' . $this->rowsError . ' errores<br>';

        if ($this->errorDetails != '') {
            $retorno .= '<br>Detalles de Errores:<br>';
            $retorno .= '=====================<br>';
            $retorno .= $this->errorDetails;
        }

        Log::info("Importación de Escuelas finalizada por usuario: " . Auth::user()->id . ": " . Auth::user()->name . " - " . $retorno);

        return $retorno;
    }

    public function batchSize(): int
    {
        return 100;
    }

    /**
     * Busca un valor en el array usando diferentes posibles nombres de columna
     */
    private function getFieldValue(array $row, array $possibleKeys)
    {
        foreach ($possibleKeys as $key) {
            // Buscar tanto en minúsculas como tal como viene
            if (isset($row[$key]) && !empty($row[$key])) {
                return $row[$key];
            }

            // Buscar en minúsculas
            $lowerKey = strtolower($key);
            if (isset($row[$lowerKey]) && !empty($row[$lowerKey])) {
                return $row[$lowerKey];
            }

            // Buscar con espacios reemplazados por guiones bajos
            $underscoreKey = str_replace(' ', '_', $lowerKey);
            if (isset($row[$underscoreKey]) && !empty($row[$underscoreKey])) {
                return $row[$underscoreKey];
            }
        }

        return null;
    }
}
