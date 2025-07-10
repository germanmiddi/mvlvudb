<?php

namespace App\Imports\Entidad;

use App\Models\Manager\AddressData;
use App\Models\Manager\AditionalData;
use App\Models\Manager\ContactData;
use App\Models\Manager\Person;

use App\Models\Manager\EntidadParticipante;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithStartRow;

use Carbon\Carbon;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class EntidadPaticipante implements ToModel, WithHeadingRow, WithBatchInserts, WithMultipleSheets, WithStartRow
{
    private $rows = 0;
    private $rowsSuccess = 0;
    private $rowsError = 0;
    private $rowsDuplicados = "";
    private $rowsDuplicadosCount = 0;

    public function __construct(){}

    public function model(array $row)
    {
        ++$this->rows;

        $data = $this->buildData($row);

        if (!$data) {
            Log::error('Datos incompletos en el registro de entrevistas', ['row' => $row]);
            ++$this->rowsError;
            return null;
        }

        $check_unique = $this->checkUniqueEntidadParticipante($data);

        if (!$check_unique) {
            ++$this->rowsDuplicadosCount;
            return null;
        }

        EntidadParticipante::create($data);

        $entrevista = $this->storeEntidadParticipante($data);

        // $status_aprobada = CajasEntrevistasStatus::where('nombre', 'APROBADA')->first()->id;
        // Log::info('Estado de la entrevista', ['estado' => $data['estado'], 'estado_aprobada' => $status_aprobada]);


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

    public function checkUniqueEntidadParticipante($data)
    {
        // Verificar si la persona existe en la tabla Person
        $person = Person::where('num_documento', $data['num_documento'])
            ->where('tipo_documento_id', $data['tipo_documento_id'])
            ->first();

        if ($person) {
            // Si la persona existe, verificar si ya tiene una entrevista registrada
            $unique = EntidadParticipante::where('person_id', $person->id)
                                         ->where('entidad_id', $data['id_entidad'])
                                         ->first();

            if ($unique) {
                Log::error('La persona ya se encuentra registrada como participante en la entidad. DNI: ' . $data['num_documento']);
                $this->rowsDuplicados .= "La persona ya se encuentra registrada como participante en la entidad. DNI: " . $data['num_documento'] . "<br>";
                return null;
            }
        }

        return true;
    }

    public function storeEntidadParticipante($data)
    {
        DB::beginTransaction();
        try {
            $person = Person::updateOrCreate(
                [
                    'tipo_documento_id' => 1,
                    'num_documento' => $data['num_documento']
                ],
                [
                    'lastname' => $data['lastname'],
                    'name' => $data['name'],
                    'fecha_nac' => $data['fecha_nac'],
                    'tipo_documento_id' => 1,
                    'num_documento' => $data['num_documento']
                ]
            );

            ContactData::updateOrCreate(
                [
                    'person_id' => $person->id
                ],
                [
                    'phone' => $data['telefono'],
                    'email' => $data['email']
                ]
            );

            $entrevista = EntidadParticipante::create(
                [
                    'person_id' => $person->id,
                    'entidad_id' => $data['id_entidad'],
                    'entidad_rol_id' => $data['rol_id']
                ]
            );

            Log::info('Participante creado correctamente',
            ["Usuario" => Auth::user()->id . ": " . Auth::user()->name, "Participante" => $entrevista->id]);

            ++$this->rowsSuccess;

            DB::commit();
            return $entrevista;

        } catch (\Throwable $th) {
            DB::rollBack();
            ++$this->rowsError;
            Log::info('Participante de la Linea N° ' . strval($this->rows + 1) . ' del archivo no se ha sido almacenar. Error: ' . $th->getMessage() );
        }
    }

    public function buildData($row)
    {

        $requiredFields = [
            'id_entidad' => 'ID ENTIDAD',
            'rol_id' => 'ID ROL',
            'apellido' => 'Apellido',
            'nombre' => 'Nombre',
            'num_documento' => 'Número de Documento',
        ];

        $allFields = [
            'id_entidad',
            'rol_id',
            'numero_entidad',
            'nombre_entidad',
            'nombre',
            'apellido',
            'num_documento',
            'telefono',
            'email',
            'fecha_nacimiento'
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

            'id_entidad' => $row['id_entidad'],
            'numero_entidad' => $row['numero_entidad'],
            'nombre_entidad' => $row['nombre_entidad'],
            'nombre' => $row['nombre'],
            'apellido' => $row['apellido'],
            'num_documento' => $row['num_documento'],
            'fecha_nacimiento' => $this->formatDate($row['fecha_nacimiento']),

            // * Contact Data
            'telefono' => $row['telefono'],
            'email' => $row['email'],

        ];

        return $data;
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

    public function startRow(): int
    {
        return 1; // Comenzamos a procesar desde la fila 3 (omitiendo las dos primeras)
    }
}

