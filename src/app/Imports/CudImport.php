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
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class CudImport implements ToModel,WithHeadingRow, WithBatchInserts
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

    public function model(array $row)
    {
        ++$this->rows;  
            try {
                $person = Person::where('num_documento', $row['n_dni'])->first();
                Cud::where('person_id', $person->id)->update(
                    [
                        'codigo' => strtoupper(str_replace(' ', '', $row['n_cud'])) !== 'NULL' ? $row['n_cud'] : null,
                        'diagnostico' => strtoupper(str_replace(' ', '', $row['n_diagnostico'])) !== 'NULL' ? $row['n_diagnostico'] : null
                    ]
                );
                DB::commit();
            } catch (\Throwable $th) {
                DB::rollBack();
                ++$this->rowsError;
                $this->entidadesNoRegistradas .= ' - Tramite de la Linea N° ' . strval($this->rows + 1) . ' del archivo no se ha sido almacenar. Error: ' . $th->getMessage() . '<br>';
                Log::error("Se ha generado un error al momento de almacenar el tramite de la linea N° " . strval($this->rows + 1), ["Modulo" => "ImportDiscapacidad:store", "Usuario" => Auth::user()->id . ": " . Auth::user()->name, "Error" => $th->getMessage()]);
            }
            return;

    }

    public function getStatus() 
    {
        $retorno = 'PROCESO DE IMPORTADOR DE TRAMITES FINALIZADO <br>';
        $retorno .= '=====================================<br>';
        $retorno .= 'Se han procesado un total de '.strval($this->rows).' registros <br>';
        $retorno .= 'Se ha registrado un total de '.strval($this->rowsSuccess). ' registros correctamente <br>';
        $retorno .= 'Se ha registrado un total de '.strval($this->rowsDuplicados). ' registros duplicados <br>';
        $retorno .= 'Se ha registrado un total de '.strval($this->rowsError). ' registros con errores <br>';
        
        if($this->entidadesNoRegistradas != ''){
            $retorno .= '<br>Registros con Errores<br>';
            $retorno .= '=====================================<br>';
            $retorno .= $this->entidadesNoRegistradas;
        }

        Log::info("Importador de Tramite de Discapacidad, ejecutado por el usuario:  ".Auth::user()->id . ": " . Auth::user()->name."<br>=> ".$retorno);

        if($this->registrosDuplidados != ''){
            $retorno .= '<br>Registros Duplicados<br>';
            $retorno .= '=====================================<br>';
            $retorno .= $this->registrosDuplidados;
        }

        Log::info($retorno);
        return $retorno;
    }

    public function batchSize(): int
    {
        return 1000;
    }

}
