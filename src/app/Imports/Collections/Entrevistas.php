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
use App\Models\Manager\Cud;
use App\PersonProgramaSocial;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithStartRow;

use App\Services\CajasServices;

use Carbon\Carbon;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class Entrevistas implements ToModel, WithHeadingRow, WithBatchInserts, WithMultipleSheets, WithStartRow
{
    private $rows = 0;
    private $rowsSuccess = 0;
    private $rowsError = 0;
    private $rowsDuplicados = "";
    private $rowsDuplicadosCount = 0;
    private $CajasServices;

    public function __construct()
    {
        $this->CajasServices = new CajasServices();

    }

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

        $entrevista = $this->storeEntrevista($data);

        $status_aprobada = CajasEntrevistasStatus::where('nombre', 'APROBADA')->first()->id;
        Log::info('Estado de la entrevista', ['estado' => $data['estado'], 'estado_aprobada' => $status_aprobada]);

        if ($data['estado'] == $status_aprobada) {
            $this->CajasServices->createTramite($entrevista);
        }
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
                Log::error('La persona ya cuenta con una entrevista registrada. DNI: ' . $data['num_documento']);
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
                    // 'cant_hijos' => $data['cant_hijos'],
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
            SocialData::updateOrCreate(
                [
                    'person_id' => $person->id
                ],
                [
                    'tipo_ocupacion_id' => $data['tipo_ocupacion_id'],
                    'cobertura_medica_id' => $data['cobertura_medica_id'],
                    'tipo_pension_id' => $data['tipo_pension_id']
                ]
            );

            EducationData::updateOrCreate(
                [
                    'person_id' => $person->id
                ],
                [
                    'nivel_educativo_id' => $data['nivel_educativo_id'],
                    'estado_educativo_id' => $data['estado_educativo_id']
                ]
            );

            // $status_pendiente = CajasEntrevistasStatus::where('nombre', 'PENDIENTE')->first()->id;

            if ($data['cud']) {
                Cud::updateOrCreate(
                    [
                        'person_id' => $person->id
                    ],
                    [
                        'codigo' => $data['cud'],
                        'diagnostico' => $data['diagnostico']
                    ]
                );
            }


            $entrevista = CajasEntrevista::create(
                [
                    'person_id' => $person->id,
                    'fecha' => $data['fecha_entrevista'],
                    'entrevistador_id' => $data['entrevistador_id'],
                    'puntos_entrega_id' => $data['sede_id'],
                    'status_id' => $data['estado'],
                    'created_by' => Auth::user()->id,
                    'vive_solo' => $data['vive_solo'],
                    'cant_convivientes' => $data['cant_convivientes'],
                    'habitacional_tipo_tenencia_id' => $data['tenencia'],
                    'ambientes' => $data['ambientes'],
                    'has_hijos' => $data['has_hijos'],
                    'cant_hijos' => $data['cant_hijos'],
                    'cant_personas_trabajando' => $data['cant_personas_trabajando'],
                    'conviviente_discapacidad' => $data['conviviente_discapacidad'],
                    'observaciones' => $data['observaciones'],
                    'ingresos_trabajo' => $data['ingresos_trabajo'],
                    'ingresos_planes' => $data['ingresos_planes'],
                    'medicacion' => $data['medicacion'],
                    'tratamiento_medico' => $data['tratamiento_medico'],
                    'discapacidad' => $data['discapacidad'],
                ]
            );

            $person->programaSocial()->sync($data['programa_social_ids']);

            Log::info('Entrevista creada correctamente', ["Usuario" => Auth::user()->id . ": " . Auth::user()->name, "Entrevista" => $entrevista->id]);

            ++$this->rowsSuccess;

            DB::commit();
            return $entrevista;

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
            'fecha',
            'sede',
            'entrevistador',
            'observaciones',
            'estado',
            'tipo_documento',
            'num_documento',
            'apellido',
            'nombre',
            'fecha_nacimiento',
            'email',
            'telefono',
            'celular',
            'localidad',
            'barrio',
            'calle',
            'numero',
            'piso',
            'departamento',
            'pais_de_origen',
            'situacion_conyugal',
            'vive_solo',
            'cant_convivientes',
            'hijos_a_cargo',
            'cuantos_hijos_tiene',
            'cuantas_personas_trabajan_en_el_hogar',
            'conviviente_con_disca',
            'tenencia',
            'ambientes',
            'nivel_educativo',
            'nivel_educativo_alcanzado',
            'ocupacion',
            'ingresos_trabajo',
            'percibe_jubilacion_pension',
            'ingresos_pension',
            'programa_social',
            'cobertura_salud',
            'recibe_tratamiento_medico',
            'cual_tratamiento_medico',
            'recibe_medicacion',
            'cual_medicacion',
            'tiene_discapacidad',
            'nro_cud',
            'diagnotico'
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
            'estado' => $this->extractID($row['estado']),
            'tipo_documento_id' => $this->extractID($row['tipo_documento']),
            'num_documento' => $row['num_documento'],
            'lastname' => $row['apellido'],
            'name' => $row['nombre'],
            'fecha_nac' => $this->formatDate($row['fecha_nacimiento']),

            // * Aditional Data
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
            'tipo_pension_id' => $this->extractID($row['percibe_jubilacion_pension']),
            'programa_social_id' => $this->extractID($row['programa_social']),

            // * Education Data
            'nivel_educativo_id' => $this->extractID($row['nivel_educativo']),
            'estado_educativo_id' => $this->extractID($row['nivel_educativo_alcanzado']),

            // * Entrevista Data
            'fecha_entrevista' => $this->formatDate($row['fecha']),
            'entrevistador_id' => $this->extractID($row['entrevistador']),
            'sede_id' => $this->extractID($row['sede']),
            'observaciones' => $row['observaciones'],
            'vive_solo' => $this->defineBoolean($row['vive_solo']),
            'cant_convivientes' => $row['cant_convivientes'],
            'tenencia' => $this->extractID($row['tenencia']),
            'ambientes' => $row['ambientes'],

            'has_hijos' => $this->defineBoolean($row['hijos_a_cargo']),
            'cant_hijos' => $row['cuantos_hijos_tiene'],
            'cant_personas_trabajando' => $row['cuantas_personas_trabajan_en_el_hogar'],
            'conviviente_discapacidad' => $this->defineBoolean($row['conviviente_con_disca']),
            'ingresos_trabajo' => $row['ingresos_trabajo'],
            'ingresos_planes' => $row['ingresos_pension'],

            'medicacion' => $row['cual_medicacion'],
            'tratamiento_medico' => $row['cual_tratamiento_medico'],
            'discapacidad' => $this->defineBoolean($row['tiene_discapacidad']),
            'programa_social' => $row['programa_social'],

            // * Cud
            'cud' => $row['nro_cud'],
            'diagnostico' => $row['diagnotico'],
        ];

        //convertir el programa social a un array
        if (!empty($row['programa_social'])) {

            $programa_social = explode(';', $row['programa_social']);

            foreach ($programa_social as $programa) {
                $programa_social_id[] = $this->extractID(trim($programa));
            }

        }
        $data['programa_social_ids'] = $programa_social_id;

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

    private function defineBoolean($value)
    {
        if (empty($value)) {
            return null;
        }

        if (strtolower($value) == 'si' || strtolower($value) == 'sí') {
            return true;
        }
        return false;
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
        return 3; // Comenzamos a procesar desde la fila 3 (omitiendo las dos primeras)
    }
}

