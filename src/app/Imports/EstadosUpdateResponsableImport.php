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
use Illuminate\Support\Str;

class EstadosUpdateResponsableImport implements ToModel,WithHeadingRow, WithBatchInserts
{
    private $rows = 0;
    private $rowsSuccess = 0;
    private $rowsError = 0;
    private $rowsDuplicados = 0;
    private $entidadesNoRegistradas = '';
    private $registrosDuplidados = '';
    //private $estadoPrevio = 1;
    private $emailPrevio = '';
    private $n_tramite_previo = 1;

    public function model(array $row)
    {
        ++$this->rows;  
        try {

            // Buscar si usuario existe en la base de datos.
            $user = User::where('email', $row['email'])->first();
            if(!$user){
                // Si no existe creao el usuario.
                User::create([
                    'name' => $row['name'],
                    'email' => $row['email'],
                    'password' => bcrypt(Str::random(12)) 
                ]);
                $user = User::where('email', $row['email'])->first();
            }
            

            $tramite = Tramite::where('num_tramite_legacy', $row['num_tramite_legacy'])->get();

            if($tramite){
                // Recuperar ultimo comentario del tramite legacy para verificar si debemos actualizar assigned
                $tramite_comment_last = TramiteComment::where('tramite_id', $tramite[0]->id)->latest()->first();

                TramiteComment::where('tramite_id', $tramite[0]->id)->where('updated_at', Carbon::parse($row['fecha'])->format('Y-m-d H:i:s'))->update(
                    [
                        'user_id' => $user->id,
                        'updated_at' => Carbon::parse($row['fecha'])->format('Y-m-d H:i:s'),
                        'created_at' => Carbon::parse($row['fecha'])->format('Y-m-d H:i:s')
                    ]
                );

                if(Carbon::parse($tramite_comment_last->updated_at)->format('Y-m-d H:i:s') === $row['fecha']){
                    // Se que actualizar el Assigned_at y el comentario
                    Tramite::where('id', $tramite[0]->id)->update(
                        [
                            'assigned' => $user->id
                        ]
                    );
                }
                ++$this->rowsSuccess;
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