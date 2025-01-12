<?php

namespace App\Imports\Collections;

use App\Models\Manager\AddressData;
use App\Models\Manager\AditionalData;
use App\Models\Manager\ContactData;
use App\Models\Manager\EducationData;
use App\Models\Manager\Person;
use App\Models\Manager\SocialData;
use App\Models\Manager\CajasEntrevista;
use App\Models\Manager\CajasEntrevistasStatus;

use App\PersonProgramaSocial;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithBatchInserts;

use Carbon\Carbon;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class Entrevistas implements ToModel, WithHeadingRow, WithBatchInserts, WithMultipleSheets
{
    private $rows = 0;
    private $rowsSuccess = 0;
    private $rowsError = 0;
    private $rowsDuplicados = "";
    private $rowsDuplicadosCount = 0;
    
    public function model(array $row)
    {
        ++$this->rows;

        $data = $this->buildData($row);

        if (!$data) {
            Log::error('Datos incompletos en el registro de entrevistas', ['row' => $row]);
            ++$this->rowsError;
            return null;
        }

        $check_unique = $this->checkUniqueEntrevista($data);

        if (!$check_unique) {
            ++$this->rowsDuplicadosCount;

            return null;
        }

        $this->storeEntrevista($data);
        return;
    }

    private function isRowEmpty(array $row): bool
    {
        foreach ($row as $value) {
            if (!empty($value)) {
                return false;
            }
        }
        return true;
    }

    public function checkUniqueEntrevista($data)
    {
        // Verificar si la persona existe en la tabla Person
        $person = Person::where('num_documento', $data['num_documento'])
                        ->where('tipo_documento_id', $data['tipo_documento_id'])
                        ->first();

        if ($person) {
            // Si la persona existe, verificar si ya tiene una entrevista registrada
            $unique = CajasEntrevista::where('person_id', $person->id)->first();

            if ($unique) {
                Log::error('La persona ya cuenta con una entrevista registrada. DNI: '.$data['num_documento'] );
                $this->rowsDuplicados .= "La persona ya cuenta con una entrevista registrada. DNI: " . $data['num_documento'] . "<br>";
                return null;
            }
        }

        return true;
    }

    public function storeEntrevista($data)
    {
        DB::beginTransaction();
        try {
            $person = Person::updateOrCreate(
                [
                    'tipo_documento_id' => $data['tipo_documento_id'],
                    'num_documento' => $data['num_documento']
                ],
                [
                    'lastname' => $data['lastname'],
                    'name' => $data['name'],
                    'fecha_nac' => $data['fecha_nac'],
                    'tipo_documento_id' => $data['tipo_documento_id'],
                    'num_documento' => $data['num_documento']
                ]
            );

            $aditionalData = AditionalData::updateOrCreate(
                [
                    'person_id' => $person->id
                ],
                [
                    'cant_hijos' => $data['cant_hijos'],
                    'situacion_conyugal_id' => $data['situacion_conyugal_id'],
                    'nacionalidad' => $data['pais_id'],
                ]
            );

            AddressData::updateOrCreate(
                [
                    'person_id' => $person->id
                ],
                [
                    'calle' => $data['calle'],
                    'number' => $data['number'],
                    'piso' => $data['piso'],
                    'dpto' => $data['dpto'],
                    'pais_id' => $data['pais_id'],
                    'localidad_id' => $data['localidad_id'],
                    'barrio_id' => $data['barrio_id'],
                ]
            );

            ContactData::updateOrCreate(
                [
                    'person_id' => $person->id
                ],
                [
                    'phone' => $data['phone'],
                    'celular' => $data['celular'],
                    'email' => $data['email']
                ]
            );

            // * Social Data
            SocialData::where('person_id', $person->id)->update(
                [
                    'tipo_ocupacion_id' => $data['tipo_ocupacion_id'],
                    'cobertura_medica_id' => $data['cobertura_medica_id'],
                    'tipo_pension_id' => $data['tipo_pension_id'],
                    'programa_social_id' => $data['programa_social_id']
                ]
            );

            EducationData::where('person_id', $person->id)->update(
                [
                    'nivel_educativo_id' => $data['nivel_educativo_id'],
                    'estado_educativo_id' => $data['estado_educativo_id']
                ]
            );


            $status_pendiente = CajasEntrevistasStatus::where('nombre', 'PENDIENTE')->first()->id;


            $entrevista = CajasEntrevista::updateOrCreate(
                ['person_id' => $person->id],
                [
                    'fecha' => $data['fecha_entrevista'],
                    'entrevistador_id' => $data['entrevistador_id'],
                    'puntos_entrega_id' => $data['sede_id'],
                    'status_id' => $status_pendiente,
                    'created_by' => Auth::user()->id,
                    'vive_solo' => $data['vive_solo'],
                    'cant_convivientes' => $data['cant_convivientes'],
                    'tenencia' => $data['tenencia'],
                    'pago_inquilino' => $data['pago_inquilino'],
                    'ambientes' => $data['ambientes'],
                ]
            );

            $entrevista->save();

            Log::info('Entrevista creada correctamente', ["Usuario" => Auth::user()->id . ": " . Auth::user()->name, "Entrevista" => $entrevista->id]);

            ++$this->rowsSuccess;

            DB::commit();

        } catch (\Throwable $th) {
            DB::rollBack();
            ++$this->rowsError;
            $this->entidadesNoRegistradas .= ' - Tramite de la Linea N° ' . strval($this->rows + 1) . ' del archivo no se ha sido almacenar. Error: ' . $th->getMessage() . '<br>';
        }
    }

    public function buildData($row)
    {

        $requiredFields = [
            'apellido' => 'Apellido',
            'nombre' => 'Nombre',
            'fecha_nacimiento' => 'Fecha de Nacimiento',
            'tipo_documento' => 'Tipo de Documento',
            'num_documento' => 'Número de Documento',
            'fecha_entrevista' => 'Fecha de Entrevista',
            'entrevistador' => 'Entrevistador',
            'sede' => 'Sede',
            'calle' => 'Calle',
            'numero' => 'Número',
            'localidad' => 'Localidad'
        ];

        $allFields = [
            'tipo_documento',
            'num_documento',
            'apellido',
            'nombre',
            'fecha_nacimiento',
            'cant_hijos',
            'situacion_conyugal',
            'pais_de_origen',
            'calle',
            'numero',
            'piso',
            'departamento',
            'localidad',
            'barrio',
            'telefono',
            'celular',
            'email',
            'ocupacion',
            'cobertura_salud',
            'recibe_pension',
            'programa_social',
            'nivel_educativo',
            'nivel_educativo_alcanzado',
            'fecha',
            'entrevistador',
            'sede',
            'vive_solo',
            'cant_convivientes',
            'tenencia',
            'pago_inquilino',
            'ambientes'
        ];

        // Check if all columns exist and required fields are not empty
        foreach ($allFields as $field) {
            if (!array_key_exists($field, $row)) {
                Log::error("Columna faltante: $field", ['row' => $row]);
                return null;
            }

            // Check if the field is required and not empty
            if (array_key_exists($field, $requiredFields) && empty($row[$field])) {
                Log::error("Campo obligatorio faltante: {$requiredFields[$field]}", ['row' => $row]);
                return null;
            }
        }

        $data = [
            'tipo_documento_id' => $this->extractID($row['tipo_documento']),
            'num_documento' => $row['num_documento'],
            'lastname' => $row['apellido'],
            'name' => $row['nombre'],
            'fecha_nac' => $this->formatDate($row['fecha_nacimiento']),

            // * Aditional Data
            'cant_hijos' => $row['cant_hijos'],
            'situacion_conyugal_id' => $this->extractID($row['situacion_conyugal']),
            'pais_id' => $this->extractID($row['pais_de_origen']),

            // * Address Data
            'calle' => $row['calle'],
            'number' => $row['numero'],
            'piso' => $row['piso'],
            'dpto' => $row['departamento'],
            'localidad_id' => $this->extractIDLocalidades($row['localidad']),
            'barrio_id' => $this->extractID($row['barrio']),

            // * Contact Data
            'phone' => $row['telefono'],
            'celular' => $row['celular'],
            'email' => $row['email'],


            // * Social Data
            'tipo_ocupacion_id' => $this->extractID($row['ocupacion']),
            'cobertura_medica_id' => $this->extractID($row['cobertura_salud']),
            'tipo_pension_id' => $this->extractID($row['recibe_pension']),
            'programa_social_id' => $this->extractID($row['programa_social']),

            // * Education Data
            'nivel_educativo_id' => $this->extractID($row['nivel_educativo']),
            'estado_educativo_id' => $this->extractID($row['nivel_educativo_alcanzado']),


            // * Entrevista Data
            'fecha_entrevista' => $this->formatDate($row['fecha']),
            'entrevistador_id' => $this->extractID($row['entrevistador']),
            'sede_id' => $this->extractID($row['sede']),
            'vive_solo' => $row['vive_solo'],
            'cant_convivientes' => $row['cant_convivientes'],
            'tenencia' => $row['tenencia'],
            'pago_inquilino' => $row['pago_inquilino'],
            'ambientes' => $row['ambientes'],
        ];

        return $data;
    }

    /**
     * Extrae el ID numérico del inicio de una cadena
     * Por ejemplo: "1 - DNI" devuelve 1, "2 - LC" devuelve 2
     * Se usa para extraer IDs de campos que vienen con formato "ID - Descripción" en el Excel
     * 
     * @param string|null $rowID La cadena de la que extraer el ID
     * @return int|null El ID numérico extraído o null si no se encuentra
     */
    private function extractID($rowID)
    {
        if (empty($rowID)) {
            return null;
        }

        if (preg_match('/^\d+/', $rowID, $matches)) {
            return (int) $matches[0];
        } else {
            return null;
        }
    }

    private function extractIDLocalidades($value)
    {
        if (empty($value)) {
            return null;
        }

        if (preg_match('/_(\d+)$/', $value, $matches)) {
            return (int) $matches[1];
        } else {
            return null;
        }

    }
    private function formatDate($date)
    {
        // dd($date);
        if (empty($date)) {
            return null;
        }

        try {
            // Check if the date is in the format d/m/Y
            if (preg_match('/^\d{2}\/\d{2}\/\d{4}$/', $date)) {
                return Carbon::createFromFormat('d/m/Y', $date)->format('Y-m-d');
            }

            // If the date is numeric, it might be an Excel date
            if (is_numeric($date)) {
                return Carbon::createFromFormat('Y-m-d', \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($date)->format('Y-m-d'));
            }

            // Default parsing
            return Carbon::parse($date)->format('Y-m-d');

        } catch (\Exception $e) {
            Log::error("Error al formatear la fecha: {$e->getMessage()}", ['date' => $date]);
            return null;
        }
    }

    public function getImportResult()
    {

        return [
            'rows' => $this->rows,
            'rowsSuccess' => $this->rowsSuccess,
            'rowsError' => $this->rowsError,
            'rowsDuplicados' => $this->rowsDuplicados,
            'rowsDuplicadosCount' => $this->rowsDuplicadosCount
        ];
    }

    public function batchSize(): int
    {
        return 1000;
    }

    public function sheets(): array
    {
        return [
            0 => $this // Aquí asumimos que la primera hoja tiene el índice 0
        ];
    }    
}

