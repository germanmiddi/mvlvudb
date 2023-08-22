<?php

namespace App\Imports;

use App\Models\Manager\Tramite;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class DiscapacidadImport implements ToModel,WithHeadingRow
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
                if(!Tramite::where('id', 1)->first()){

                    ++$this->rowsSuccess; 
                    Log::info("Se ha importado correctamente la entidad N° , bajo el ID de entidad N° ", ["Modulo" => "ImportEntidad:store","Usuario" => Auth::user()->id.": ".Auth::user()->name]);
                }else{
                    ++$this->rowsDuplicados; 
                    $this->registrosDuplidados .= ' - Entidad N° , correspondiente a la Linea N° '. strval($this->rows+1).' del archivo ha sido cargado previamente. <br>'; 
                    Log::info("La entidad N° , ha sido cargado previamente", ["Modulo" => "ImportEntidad:store","Usuario" => Auth::user()->id.": ".Auth::user()->name]);
                }
            }catch (\Throwable $th) {
                ++$this->rowsError;
                $this->entidadesNoRegistradas .= ' - Entidad N° , correspondiente a la Linea N° '. strval($this->rows+1).' del archivo no se ha sido almacenar. Error: '.strstr($th->getMessage(), "(SQL", true).'<br>'; 
                Log::error("Se ha generado un error al momento de almacenar la entidad N° ", ["Modulo" => "ImportEntidad:store","Usuario" => Auth::user()->id.": ".Auth::user()->name, "Error" => $th->getMessage() ]);
            }
        return; 

    }

    public function getStatus() 
    {
        $retorno = 'PROCESO DE IMPORTADOR DE ENTIDADES FINALIZADO <br>';
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

        if($this->registrosDuplidados != ''){
            $retorno .= '<br>Registros Duplicados<br>';
            $retorno .= '=====================================<br>';
            $retorno .= $this->registrosDuplidados;
        }

        return $retorno;
    }
}
