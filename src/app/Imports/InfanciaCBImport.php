<?php

namespace App\Imports;

use App\Models\Manager\AddressData;
use App\Models\Manager\AditionalData;
use App\Models\Manager\AutorizacionCb;
use App\Models\Manager\CbiData;
use App\Models\Manager\ContactData;
use App\Models\Manager\Cud;
use App\Models\Manager\EducationData;
use App\Models\Manager\LegajoCB;
use App\Models\Manager\Person;
use App\Models\Manager\SaludData;
use App\Models\Manager\SocialData;
use App\Models\Manager\TipoDocumento;
use App\Models\Manager\TipoLegajoCb;
use App\Models\Manager\Tramite;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithBatchInserts;

class InfanciaCBImport implements ToModel, WithHeadingRow //, WithBatchInserts
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

    protected $sede_id;

    function __construct($param)
    {
        $this->sede_id = $param;
    }

    public function model(array $row)
    {
        DB::beginTransaction();
        ++$this->rows;
        try {
            if (!is_int($row['dni'])) {
                ++$this->rowsError;
                $this->entidadesNoRegistradas .= ' - Tramite de la Linea N° ' . strval($this->rows + 1) . ' no es posible reconocer el formato del DNI.<br>';
                return;
            }
            $tipo_documento = TipoDocumento::where('description', 'DNI')->first();
            $person = Person::updateOrCreate(
                [
                    'num_documento' => $row['dni'],
                    'tipo_documento_id' => $tipo_documento->id
                ],
                [
                    'lastname' => $row['apellido'],
                    'name' => $row['nombre'],
                    'fecha_nac' => $this->verificarFormatoDate($row['fecha_nacimiento']),
                ]
            );

            ContactData::updateOrCreate(
                [
                    'person_id' => $person->id
                ],
                [
                    'phone' => $row['telefono'],
                    'email' => $row['email']
                ]
            );

            AddressData::updateOrCreate(
                [
                    'person_id' => $person->id
                ],
                [
                    'calle' => $row['calle'] ?? null,
                    'number' => $row['numero'] ?? null,
                    'piso' => $row['piso'] ?? null,
                    'dpto' => $row['departamento'] ?? null

                ]
            );

            SaludData::updateOrCreate(
                [
                    'person_id' => $person->id
                ],
                [
                    'apto_medico' => $row['apto_medico'] === 'SI' ? true : ($row['apto_medico'] === 'NO' ? false : null),
                    'electrocardiograma' => $row['electrocardiograma'] === 'SI' ? true : ($row['electrocardiograma'] === 'NO' ? false : null),
                    'libreta_vacunacion' => $row['libreta_vacunacion'] === 'SI' ? true : ($row['libreta_vacunacion'] === 'NO' ? false : null),

                ]
            );

            Cud::updateOrCreate(
                [
                    'person_id' => $person->id
                ],
                [
                    'posee_cud' => $row['cud'] === 'SI' ? true : ($row['cud'] === 'NO' ? false : null),
                    'presento_cud' => $row['cud_presentado'] === 'SI' ? true : ($row['cud_presentado'] === 'NO' ? false : null),
                ]
            );

            EducationData::updateOrCreate(
                [
                    'person_id' => $person->id
                ],
                [
                    'permanencia' => $row['realizo_permanencia'] === 'SI' ? true : ($row['realizo_permanencia'] === 'NO' ? false : null),
                    'certificado_escolar' => $row['presenta_certificado_escolar'] === 'SI' ? true : ($row['presenta_certificado_escolar'] === 'NO' ? false : null),
                ]
            );

            // Carga de LegajoCB
            if (LegajoCB::where('person_id', $person->id)->exists()) {
                ++$this->rowsError;
                $this->entidadesNoRegistradas .= ' - Tramite de la Linea N° ' . strval($this->rows + 1) . ' posee un legajo existente.<br>';
            } else {
                $tipo_legajo_cb = TipoLegajoCb::where('description', 'Centro Barrial Infancia')->first();


                $legajo = LegajoCB::Create(
                    [
                        'person_id' => $person->id,
                        'fecha_inscripcion' => $this->verificarFormatoDate($row['fecha_inscripcion']),
                        'fecha_inicio' => $this->verificarFormatoDate($row['fecha_inicio_cb']),
                        'parentesco_id' => $row['parentesco_id'] ?? null,
                        'phone_emergency' => $row['telefono_de_emergencia'] ?? null,
                        'tipo_legajo_id' => $tipo_legajo_cb['id'],
                        'sede_id' => $this->sede_id
                    ]
                );

                AutorizacionCb::updateOrCreate(
                    [
                        'legajo_id' => $legajo->id
                    ],
                    [
                        'apoyo_escolar' => $row['aut_apoyo_escolar'] === 'SI' ? true : ($row['aut_apoyo_escolar'] === 'NO' ? false : null),
                        'autorizacion_firmada' =>  $row['aut_firmada'] === 'SI' ? true : ($row['aut_firmada'] === 'NO' ? false : null),
                        'autorizacion_retirarse' =>  $row['aut_retirarse'] === 'SI' ? true : ($row['aut_retirarse'] === 'NO' ? false : null),
                        'autorizacion_uso_imagen' =>  $row['aut_uso_imagen'] === 'SI' ? true : ($row['aut_uso_imagen'] === 'NO' ? false : null),
                    ]
                );
                // verifica si existe responsable
                if ($row['dni_adulto'] != '') {
                    $responsable = Person::updateOrCreate(
                        [
                            'tipo_documento_id' => $tipo_documento->id,
                            'num_documento' => $row['dni_adulto']
                        ],
                        [
                            'name' => $row['nombre_adulto'],
                            'lastname' => $row['apellido_adulto'],
                            'name' => $row['nombre_adulto'],
                            'fecha_nac' => $this->verificarFormatoDate($row['fecha_nac_adulto']), //date("Y-m-d ", strtotime($row['fecha_nac_adulto'])),
                        ]
                    );

                    ContactData::updateOrCreate(
                        [
                            'person_id' => $responsable['id']
                        ],
                        [
                            'phone' => $row['telefono_adulto'] ?? null
                        ]
                    );

                    LegajoCB::updateOrCreate(
                        [
                            'id' => $legajo->id
                        ],
                        [
                            'responsable_id' => $responsable->id
                        ]
                    );
                }
                ++$this->rowsSuccess;
            }
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

        Log::info("Importador de Tramite de Juventud, ejecutado por el usuario:  " . Auth::user()->id . ": " . Auth::user()->name . "<br>=> " . $retorno);

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

    function verificarFormatoDate($date)
    {
        if ($this->isNumericDate($date)) {
            // Si el dato es numérico, podríamos asumir que es un número de serie de Excel
            return $this->convertDateExcel($date);
        } elseif ($date === null) {
            return null;
        } else {
            // De lo contrario, tratamos de parsear el dato como una fecha textual
            return date("Y-m-d ", strtotime($date));
        }
    }

    function convertDateExcel($excelDate)
    {
        $excelBaseDate = Carbon::create(1900, 1, 1);
        $daysOffset = $excelDate - 2; // Ajusta por el error bisiesto de Excel
        return $excelBaseDate->addDays($daysOffset);
    }

    function isNumericDate($data)
    {
        // Verifica si el dato es numérico y tiene 5 dígitos o más (o ajusta según tus necesidades)
        return is_numeric($data) && strlen((string) $data) >= 5;
    }
}
