<?php

namespace App\Imports;

use App\Models\Manager\AutoridadEntidad;
use App\Models\Manager\Entidad;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithBatchInserts;

class EntidadImport implements ToModel,WithHeadingRow
{
    /**
    * @param Collection $collection
    */

    // Cantidad de Registros

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
                if(!Entidad::where('num_entidad', $row['numero'])->first()){

                    /**
                     * Conversion de id_localidad "DETALLE EN SEEDER LocalidadesSeeder
                     */

                    switch ($row['id_localidad']) {
                        case 3:
                            $row['id_localidad'] = 5;
                            break;
                        case 5:
                            $row['id_localidad'] = 9;
                            break;
                        case 6:
                            $row['id_localidad'] = 10;
                            break;
                        case 7:
                            $row['id_localidad'] = 14;
                            break;
                        case 8:
                            $row['id_localidad'] = 12;
                            break;
                        case 9:
                            $row['id_localidad'] = 6;
                            break;
                        case 10:
                            $row['id_localidad'] = 4;
                            break;
                        case 16:
                            $row['id_localidad'] = 14;
                            break;
                        case 14:
                            $row['id_localidad'] = 16;
                            break;
                    }

                    $entidad = new Entidad([
                        'num_entidad' => $row['numero'],
                        'name' => $row['nombre'],
                        'objeto' => $row['objeto_social'] ?? null,
                        'address' => $row['domicilio'] ?? null,
                        'phone' => $row['tel_entidad'] ?? null,
                        'email' => $row['mail_entidad'] ?? null,
                        'solicitud_inscripcion' => $row['dec_resol'] ?? null,
                        'personeria' => $row['personeria_jur'] ?? null,
                        'eximision' => $row['ts_aysa'] ?? null,
                        'observation' => $row['obs'] ?? null,
                        'fecha_inscripcion' => isset($row['fecha_insc_pcia']) && $row['fecha_insc_pcia'] != 'NULL' ? date("Y-m-d ", strtotime($row['fecha_insc_pcia'])) : null,
                        'fecha_fundacion' => isset($row['fecha_fundacion']) && $row['fecha_fundacion'] != 'NULL' ? date("Y-m-d ", strtotime($row['fecha_fundacion'])) : null,
                        'fecha_fin_mandato' => isset($row['fecha_venc_mandato']) && $row['fecha_venc_mandato'] != 'NULL'  ? date("Y-m-d ", strtotime($row['fecha_venc_mandato'])) : null,
                        'fecha_memoria' => isset($row['mem_balance']) && $row['mem_balance'] != 'NULL' ? date("Y-m-d ", strtotime($row['mem_balance'])) : null,
                        'fecha_asamblea' => isset($row['fecha_ult_asamb']) && $row['fecha_ult_asamb'] != 'NULL' ? date("Y-m-d ", strtotime($row['fecha_ult_asamb'])) : null,
                        'tipo_entidad_id' => $row['c_entidad'] ?? null,
                        'localidad_id' => $row['id_localidad'] ?? null,
                        'tipo_actividad_id' => $row['c_actividad'] ?? null
                    ]);
                    $entidad->save();

                    if($row['presidente']){
                        AutoridadEntidad::Create(
                            [
                                'name' => $row['presidente'],
                                'phone' =>$row['tel_presidente'],
            
                                'cargo_id' => 1,
                                'entidad_id' => $entidad->id
                            ]
                        );
                    }

                    if($row['secretario']){
                        AutoridadEntidad::Create(
                            [
                                'name' => $row['secretario'],
                                'phone' =>$row['tel_secretario'],
            
                                'cargo_id' => 2,
                                'entidad_id' => $entidad->id
                            ]
                        );
                    }

                    if($row['tesorero']){
                        AutoridadEntidad::Create(
                            [
                                'name' => $row['tesorero'],
                                'phone' =>$row['tel_tesorero'],
            
                                'cargo_id' => 3,
                                'entidad_id' => $entidad->id
                            ]
                        );
                    }

                    if($row['referente']){
                        AutoridadEntidad::Create(
                            [
                                'name' => $row['referente'],
                                'phone' =>$row['tel_referente'],
            
                                'cargo_id' => 4,
                                'entidad_id' => $entidad->id
                            ]
                        );
                    }

                    ++$this->rowsSuccess; 
                    Log::info("Se ha importado correctamente la entidad N° ".$row['numero'].", bajo el ID de entidad N° ".$entidad['id'], ["Modulo" => "ImportEntidad:store","Usuario" => Auth::user()->id.": ".Auth::user()->name]);
                }else{
                    ++$this->rowsDuplicados; 
                    $this->registrosDuplidados .= ' - Entidad N° '.$row['numero'].', correspondiente a la Linea N° '. strval($this->rows+1).' del archivo ha sido cargado previamente. <br>'; 
                    Log::info("La entidad N° ".$row['numero'].", ha sido cargado previamente", ["Modulo" => "ImportEntidad:store","Usuario" => Auth::user()->id.": ".Auth::user()->name]);
                }
            }catch (\Throwable $th) {
                ++$this->rowsError;
                $this->entidadesNoRegistradas .= ' - Entidad N° '.$row['numero'].', correspondiente a la Linea N° '. strval($this->rows+1).' del archivo no se ha sido almacenar. Error: ' . $th->getMessage() . '<br>';
                Log::error("Se ha generado un error al momento de almacenar la entidad N° ".$row['numero'], ["Modulo" => "ImportEntidad:store","Usuario" => Auth::user()->id.": ".Auth::user()->name, "Error" => $th->getMessage() ]);
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
