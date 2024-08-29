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
use App\Models\Manager\TipoDocumento;
use App\Models\Manager\Tramite;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithBatchInserts;

class JuventudCBImport implements ToModel,WithHeadingRow, WithBatchInserts
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

    function __construct($param) {
        $this->sede_id = $param;
    }

    public function model(array $row)
    {
        ++$this->rows;  
        DB::beginTransaction();
        try {
            $tipo_documento = TipoDocumento::where('description', 'DNI')->first();
                
            $person = Person::updateOrCreate(
                [
                    'num_documento' => $row['dni'],
                    'tipo_documento_id' => $tipo_documento->id
                ],
                [
                    'lastname' => $row['apellido'],
                    'name' => $row['nombre'],
                    'fecha_nac' => date("Y-m-d ", strtotime($row['fecha_nacimiento'])),
                ]
            );

            /* ContactData::updateOrCreate(
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
                    'apto_medico' => $row['apto_medico'] ?? null,
                    'electrocardiograma' => $row['electrocardiograma'] ?? null,
                    'libreta_vacunacion' => $row['libreta_vacunacion_salud'] ?? null

                ]
            );

            Cud::updateOrCreate(
                [
                    'person_id' => $person->id
                ],
                [
                    'posee_cud' => $row['cud'] ?? null,
                    'presento_cud' => $row['cud_presentado'] ?? null
                ]
            );

            EducationData::updateOrCreate(
                [
                    'person_id' => $person->id
                ],
                [
                    'permanencia' => $row['realizo_permanencia'],
                    'certificado_escolar' => $row['presenta_certificado_escolar']
                ]
            ); */
            ++$this->rowsSuccess;
            DB::commit();
        
        } catch (\Throwable $th) {
            DB::rollBack();
            ++$this->rowsError;
            $this->entidadesNoRegistradas .= ' - Tramite de la Linea N° ' . strval($this->rows + 1) . ' del archivo no se ha podido almacenar. Error: ' . $th->getMessage() . '<br>';
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
