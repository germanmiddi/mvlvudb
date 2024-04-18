<?php

namespace App\Imports;

use App\Models\Manager\AcompanamientoCbj;
use App\Models\Manager\ActividadCbj;
use App\Models\Manager\AddressData;
use App\Models\Manager\AditionalData;
use App\Models\Manager\CanalAtencion;
use App\Models\Manager\CbjData;
use App\Models\Manager\Comedor;
use App\Models\Manager\ContactData;
use App\Models\Manager\Cud;
use App\Models\Manager\EducationData;
use App\Models\Manager\EstadoCbj;
use App\Models\Manager\Localidad;
use App\Models\Manager\Person;
use App\Models\Manager\Sede;
use App\Models\Manager\SocialData;
use App\Models\Manager\TipoTramite;
use App\Models\Manager\Tramite;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithBatchInserts;

class JuventudImport implements ToModel,WithHeadingRow, WithBatchInserts
{
    private $rows = 0;
    private $rowsSuccess = 0;
    private $rowsError = 0;
    private $rowsDuplicados = 0;
    private $entidadesNoRegistradas = '';
    private $registrosDuplidados = '';

    public function model(array $row)
    {
        if($row['numero'] !== null || $row['numero'] !== ''){
            DB::beginTransaction();
            ++$this->rows;  
            
            try {
                // Verifico que existan los campos/columnas minimos para la carga de un adulto responsable
                if(!isset($row['responsable_dni']) || !isset($row['responsable_nombre']) || !isset($row['responsable_apellido']) || !isset($row['responsable_fecha_nac'])){
                     // Tramite de CBJ sin un adulto responsable valido/relacionado
                    $person = $this->setBeneficiario($row);
                }else{
                    // Verifico que existan todos los minimos para la carga de un adulto responsable
                    if(($row['responsable_dni'] === 'NULL' || $row['responsable_dni'] === '')
                        || ($row['responsable_nombre'] === 'NULL' || $row['responsable_nombre'] === '')
                        || ($row['responsable_apellido'] === 'NULL' || $row['responsable_apellido'] === '')
                        || ($row['responsable_fecha_nac'] === 'NULL' || $row['responsable_fecha_nac'] === '') ){
                        // Tramite de CBJ sin un adulto responsable valido/relacionado
                        $person = $this->setBeneficiario($row);
                    }else{
                        // Tramite de CBJ con un adulto responsable valido/relacionado
                        $beneficiario = $this->setBeneficiario($row);
                        $person = $this->setResponsable($row);
                    }
                }
                
                $dependencia = TipoTramite::where('description', 'JUVENTUD')->first();
                $canal = CanalAtencion::where('description', 'CENTRO BARRIAL DE JUVENTUD')->first();
                $tipoTramite = TipoTramite::where('description', 'JUVENTUD')->first();
                $sede = Sede::where('description', $row['cbj_sede'])->first()->id ?? null;
    
                $tramite_data = Tramite::Create(
                    [
                        'fecha' => date("Y-m-d ", strtotime($row['cbj_fecha'] ?? Carbon::now())),
                        'observacion' => $row['cbj_observacion'] ?? null,
    
                        'canal_atencion_id' => $canal['id'],
                        'tipo_tramite_id' => $tipoTramite['id'],
                        'dependencia_id' => $dependencia['dependencia_id'],
                        'sede_id' => $sede,
                        'estado_id' => 1, // Estado Abierto
                    ]
                );
    
                $estadoCbj = EstadoCbj::where('description', $row['cbj_estado'])->first()->id ?? null;
                $comedor = Comedor::where('description', $row['cbj_comedor'])->first()->id ?? null;
                $actividad = ActividadCbj::where('description', $row['cbj_actividad'])->first()->id ?? null;
                $acompanamiento = AcompanamientoCbj::where('description', $row['cbj_acompanamiento'])->first()->id ?? null;
    
                CbjData::Create(
                    [
                        'anio_inicio' => $row['cbj_anio_inicio'] ?? date("Y ", strtotime(Carbon::now())),
                        'estado_cbj_id' => $estadoCbj,
                        'comedor_id' => $comedor,
                        'actividad_cbj_id' => $actividad,
                        'apoyo_escolar' => $row['cbj_apoyo_escolar'] == 'ACTIVO' ? 1 : ($row['cbj_apoyo_escolar'] == 'INACTIVO' ? 0 : null),
                        'act_empleo' => $row['cbj_actividad_empleo'] == 'ACTIVO' ? 1 : ($row['cbj_actividad_empleo'] == 'INACTIVO' ? 0 : null),
                        'acompanamiento_cbj_id'  => $acompanamiento,
                        'aut_firmada' => $row['cbj_aut_firmada'] == 'SI' ? 1 : ($row['cbj_aut_firmada'] == 'NO' ? 0 : null),
                        'aut_retirarse' => $row['cbj_aut_retirarse'] == 'SI' ? 1 :($row['cbj_aut_retirarse'] == 'NO' ? 0 : null),
                        'aut_uso_imagen' => $row['cbj_aut_uso_imagen'] == 'SI' ? 1 : ($row['cbj_aut_uso_imagen'] == 'NO' ? 0 : null),
                        'certificado_escolar' => $row['cbj_certificado_escolar'] == 'SI' ? 1 : ($row['cbj_certificado_escolar'] == 'NO' ? 0 : null),
                        'tramite_id' => $tramite_data['id'],
    
                    ]
                );
    
                $person->tramites()->attach($tramite_data['id'], ['rol_tramite_id' => 1]);
                if (isset($beneficiario)) {
                    $beneficiario->tramites()->attach($tramite_data['id'], ['rol_tramite_id' => 2]); // ROL BENEFICIARIO
                }
    
                DB::commit();
            } catch (\Throwable $th) {
                dd($row['numero']. ' _ ' .$this->rows. ' _ ' .$th);
                DB::rollBack();
                ++$this->rowsError;
                $this->entidadesNoRegistradas .= ' - Tramite de la Linea N° ' . strval($this->rows + 1) . ' del archivo no se ha sido almacenar. Error: ' . $th->getMessage() . '<br>';
                Log::error("Se ha generado un error al momento de almacenar el tramite de la linea N° " . $this->rows, ["Modulo" => "JuventudImport:store", "Usuario" => Auth::user()->id . ": " . Auth::user()->name, "Error" => $th->getMessage()]);
            }
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

    public function setBeneficiario($row){
        $person = Person::updateOrCreate(
            [
                'tipo_documento_id' => 1,
                'num_documento' => $row['beneficiario_dni']
            ],
            [
                'lastname' => strtoupper(str_replace(' ', '', $row['beneficiario_apellido'])) !== 'NULL' ? $row['beneficiario_apellido'] : null,
                'name' => strtoupper(str_replace(' ', '', $row['beneficiario_nombre'])) !== 'NULL' ? $row['beneficiario_nombre'] : null,
                'fecha_nac' => date("Y-m-d ", strtotime($row['beneficiario_fecha_nac'])),
                'tipo_documento_id' => 1,
                'num_documento' => $row['beneficiario_dni']
            ]
        );

        $address = AddressData::updateOrCreate(
            [
                'person_id' => $person->id
            ],
            [
                'calle' => strtoupper(str_replace(' ', '', $row['beneficiario_calle'])) !== 'NULL' ? $row['beneficiario_calle'] : null,
                'number' => strtoupper(str_replace(' ', '', $row['beneficiario_numero'])) !== 'NULL' ? $row['beneficiario_numero'] : null,
                'piso' => strtoupper(str_replace(' ', '', $row['beneficiario_piso'])) !== 'NULL' ? $row['beneficiario_piso'] : null,
                'dpto' => strtoupper(str_replace(' ', '', $row['beneficiario_departamento'])) !== 'NULL' ? $row['beneficiario_departamento'] : null,
            ]
        );

        if($row['beneficiario_localidad'] !== 'NULL' || $row['beneficiario_localidad'] !== '' || $row['beneficiario_localidad']){
            $row['beneficiario_localidad'] = str_replace(' ', '', $row['beneficiario_localidad']);
            $localidad_id = Localidad::select('id')->where('description', $row['beneficiario_localidad'])->first()->id ?? null;
            if($localidad_id !== null){
                $address->localidad_id = $localidad_id;
                $address->save();
            }
        }
        
        ContactData::updateOrCreate(
            [
                'person_id' => $person->id
            ],
            [
                'phone' => strtoupper(str_replace(' ', '', $row['beneficiario_telefono'])) !== 'NULL' ? $row['beneficiario_telefono'] : null,
                'email' => strtoupper(str_replace(' ', '', $row['beneficiario_email'])) !== 'NULL' ? $row['beneficiario_email'] : null,
            ]
        );

        return $person;
    }

    public function setResponsable($row){
        $person = Person::updateOrCreate(
            [
                'tipo_documento_id' => 1,
                'num_documento' => $row['responsable_dni']
            ],
            [
                'lastname' => strtoupper(str_replace(' ', '', $row['responsable_apellido'])) !== 'NULL' ? $row['responsable_apellido'] : null,
                'name' => strtoupper(str_replace(' ', '', $row['responsable_nombre'])) !== 'NULL' ? $row['responsable_nombre'] : null,
                'fecha_nac' => date("Y-m-d ", strtotime($row['responsable_fecha_nac'])),
                'tipo_documento_id' => 1,
                'num_documento' => $row['responsable_dni']
            ]
        );

        return $person;
    }
}