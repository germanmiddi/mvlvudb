<?php

namespace App\Imports;

use App\Models\Manager\AddressData;
use App\Models\Manager\AditionalData;
use App\Models\Manager\ContactData;
use App\Models\Manager\Cud;
use App\Models\Manager\EducationData;
use App\Models\Manager\Person;
use App\Models\Manager\SocialData;
use App\Models\Manager\Tramite;
use App\Models\Manager\TramiteComment;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithBatchInserts;

class EstadosImport implements ToModel,WithHeadingRow, WithBatchInserts
{
    private $rows = 0;
    private $rowsSuccess = 0;
    private $rowsError = 0;
    private $rowsDuplicados = 0;
    private $entidadesNoRegistradas = '';
    private $registrosDuplidados = '';

    public function model(array $row)
    {
        ++$this->rows;  
        try {
            $tramites = Tramite::where('num_tramite_legacy', $row['num_tramite_legacy'])->get();
            if(count($tramites) > 0){
                foreach ($tramites as $tramite) {
                    if(TramiteComment::where('tramite_id', $tramite->id)->where('created_at', Carbon::parse($row['fecha'])->format('Y-m-d H:i:s'))->first()){
                        ++$this->rowsDuplicados;
                        $this->registrosDuplidados .= ' - Estado de la Linea N° ' . strval($this->rows + 1) . ' del archivo ha sido cargado previamente. <br>';
                        Log::error("La observacion ha sido cargado previamente en el estado de la linea N° " .strval($this->rows + 1), ["Modulo" => "ImportEstados:store", "Usuario" => Auth::user()->id . ": " . Auth::user()->name]);
                    }else{
                        $user = User::where('email', $row['email'])->first();
                        TramiteComment::Create(
                            [
                                'tramite_id' => $tramite->id,
                                'user_id' => $user ? $user->id : 1,
                                'dependencia_id' => $row['dependencia_id'] !== 'NULL' && $row['dependencia_id'] !== -1 ? $row['dependencia_id'] : $tramite->dependencia_id,
                                'content' => $row['observacion'] !== 'NULL' && $row['observacion'] !== -1 ? $row['observacion'] : '',
                                'updated_at' => Carbon::parse($row['fecha'])->format('Y-m-d H:i:s'),
                                'created_at' => Carbon::parse($row['fecha'])->format('Y-m-d H:i:s')
                            ]
                        );
                        Tramite::where('id', $tramite->id)->update(
                            [
                                'estado_id' => $row['estado_id'],
                                'assigned' => $user ? $user->id : 1,
                                'updated_at' => Carbon::parse($row['fecha'])->format('Y-m-d H:i:s')
                            ]
                        );
                        ++$this->rowsSuccess;
                    }
                }
            }else{
                ++$this->rowsError;
                $this->entidadesNoRegistradas .= ' - Estado de la Linea N° ' . strval($this->rows + 1) . ' del archivo no posee ningun tramite relacionado. <br>';
            }
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            ++$this->rowsError;
            $this->entidadesNoRegistradas .= ' - Estado de la Linea N° ' . strval($this->rows + 1) . ' del archivo no se ha podido almacenar. Error: ' . $th->getMessage() . '<br>';
            Log::error("Se ha generado un error al momento de almacenar el estado de la linea N° " .strval($this->rows + 1), ["Modulo" => "ImportEstados:store", "Usuario" => Auth::user()->id . ": " . Auth::user()->name, "Error" => $th->getMessage()]);
        }
        return;
    }

    public function getStatus()
    {
        $retorno = 'PROCESO DE IMPORTADOR DE ESTADOS FINALIZADO <br>';
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

        Log::info("Importador de estados de tramites, se ha ejecutado por el usuario:  ".Auth::user()->id . ": " . Auth::user()->name."<br>=> ".$retorno);

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