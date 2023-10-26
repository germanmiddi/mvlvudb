<?php

namespace App\Http\Controllers\Manager\Import;

use App\Http\Controllers\Controller;
use App\Imports\DiscapacidadImport;
use App\Imports\EntidadImport;
use App\Imports\EstadosImport;
use App\Imports\FortalecimientoImport;
use App\Imports\GeneroImport;
use App\Imports\HabitatImport;
use App\Imports\JuventudImport;
use App\Imports\MayoresImport;
use App\Imports\NinezImport;
use App\Imports\PersonImport;
use App\Imports\PromocionImport;
use App\Models\Manager\Archivo;
use App\Models\Manager\Dependencia;
use App\Models\Manager\Entidad;
use App\Models\Manager\Tramite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Maatwebsite\Excel\Facades\Excel;

class ImportController extends Controller
{
    public function index()
    {
        return Inertia::render('Manager/Settings/Importador/Index',[
            'dependencias' => Dependencia::where('activo', true)->get()
        ]);

    }

    public function importEntidades(Request $request)
    {
        if( $request->file('file')){
                $archivoCSV = $request->file('file');
                try {
                    $import = new EntidadImport();
                    Excel::import($import, $archivoCSV);
                    $status = $import->getStatus();
                    return response()->json(['message' => 'Se ha finalizado el proceso de importacion de Entidades.', 'status' => $status], 200);
                } catch (\Exception $e) {
                    return response()->json(['message' => 'Error al procesar el archivo CSV.'], 203);
                }
        }else{
            return response()->json(['message' => 'Error al procesar el importador. Contacte al Administrador'], 203);
        }
    }

    public function importDependencias(Request $request)
    {

        if( $request->file('file')){
            try {
                $archivoCSV = $request->file('file');
                    switch ($request['dependencia_id']) {
                        case 2:
                            Log::info('Se ha iniciado el proceso de Importación de Tramite DISCAPACIDAD. <br>');
                            $import = new DiscapacidadImport();
                            break;
                        case 5:
                            Log::info('Se ha iniciado el proceso de Importación de Tramite FORTALECIMIENTO. <br>');
                            $import = new FortalecimientoImport();
                            break;
                        case 6:
                            Log::info('Se ha iniciado el proceso de Importación de Tramite GENERO. <br>');
                            $import = new GeneroImport();
                            break;
                        case 7:
                            Log::info('Se ha iniciado el proceso de Importación de Tramite HABITAT. <br>');
                            $import = new HabitatImport();
                            break;
                        case 8:
                            Log::info('Se ha iniciado el proceso de Importación de Tramite NIÑEZ. <br>');
                            $import = new NinezImport();
                            break;
                        case 9:
                            Log::info('Se ha iniciado el proceso de Importación de Tramite PROMOCIONES. <br>');
                            $import = new PromocionImport();
                            break;
                        case 13:
                            Log::info('Se ha iniciado el proceso de Importación de Tramite JUVENTUD. <br>');
                            $import = new JuventudImport();
                            break;
                        case 14:
                            Log::info('Se ha iniciado el proceso de Importación de Tramite MAYORES. <br>');
                            $import = new MayoresImport();
                            break;
                        default:
                            return response()->json(['message' => 'No se ha podido detectar una Dependencia Valida'], 203);
                            break;
                    }
                    Excel::import($import, $archivoCSV);
                    $status = $import->getStatus();

                    return response()->json(['message' => 'Se ha finalizado el proceso de importacion de tramite.', 'status' => $status], 200);
                
            } catch (\Throwable $th) {
                return response()->json(['message' => 'Error al procesar el archivo CSV.'], 203);
            }
        }else{
            return response()->json(['message' => 'Error al procesar el importador. Contacte al Administrador'], 203);
        }
    }

    public function importPersonas(Request $request)
    {
        if( $request->file('file')){
                $archivoCSV = $request->file('file');
                try {
                    $import = new PersonImport();
                    Excel::import($import, $archivoCSV);
                    $status = $import->getStatus();
                    return response()->json(['message' => 'Se ha finalizado el proceso de importacion de Personas.', 'status' => $status], 200);
                } catch (\Exception $e) {
                    dd($e);
                    return response()->json(['message' => 'Error al procesar el archivo CSV.'], 203);
                }
        }else{
            return response()->json(['message' => 'Error al procesar el importador. Contacte al Administrador'], 203);
        }
    }

    public function importEstados(Request $request)
    {
        if( $request->file('file')){
                $archivoCSV = $request->file('file');
                try {
                    $import = new EstadosImport();
                    Excel::import($import, $archivoCSV);
                    $status = $import->getStatus();
                    return response()->json(['message' => 'Se ha finalizado el proceso de importacion de Estados.', 'status' => $status], 200);
                } catch (\Exception $e) {
                    return response()->json(['message' => 'Error al procesar el archivo CSV.'], 203);
                }
        }else{
            return response()->json(['message' => 'Error al procesar el importador. Contacte al Administrador'], 203);
        }
    }

    public function importFiles(){
        $sistemaArchivos = Storage::disk('restore_legacy')->files('/');

        $files = count($sistemaArchivos);
        $filesSuccess = 0;
        $filesError = 0;
        $filesDuplicados = 0;
        $msgError = '';
        $msgDuplidados = '';
            foreach ($sistemaArchivos as $file) {
                $infoArchivo = pathinfo($file);
                // infoArchivo['basename']['extension']['filename']
                $partes = explode('$', $infoArchivo['filename']);
                /*
                Parte[0] = num_tramite_legacy
                Parte[1] = Observacion
                */
                try {
                // Copiamos el archivo del disco "restore_legacy" al disco "public"
                    Storage::disk('public')->put($file, Storage::disk('restore_legacy')->get($file));
                    // Eliminar el archivo del disco de origen si es necesario
                    Storage::disk('restore_legacy')->delete($file);
                    // Verifico si existe el tramite
                    $tramite = Tramite::where('num_tramite_legacy', $partes[0])->first();
                    if($tramite){
                        if(Archivo::where('name', $infoArchivo['basename'])->first()){
                            $filesDuplicados++; 
                            $msgDuplidados .= ' - El archivo '.$infoArchivo['basename'].' correspondiente al tramite legacy N° '.$partes[0].', ya se encuentra ingresado en el Sistema. <br>'; 
                            Log::info( 'El archivo '.$infoArchivo['basename'].' correspondiente al tramite legacy N° '.$partes[0].', ya se encuentra ingresado en el Sistema. ', ["Modulo" => "Import:importFiles","Usuario" => Auth::user()->id.": ".Auth::user()->name]);
                        }else{
                            Archivo::create([
                                'name' => $infoArchivo['basename'],
                                'description' => $partes[1],
                                'ext' => $infoArchivo['extension'],
                                'tramite_id' => $tramite->id
                            ]);
                            $filesSuccess++; 
                            Log::info('El archivo '.$infoArchivo['basename'].' correspondiente al tramite legacy N° '.$partes[0].', se ha ingresado correctamente al Sistema.', ["Modulo" => "Import:importFiles","Usuario" => Auth::user()->id.": ".Auth::user()->name]);
                        }
                    }else{
                        $filesError++; 
                        $msgError .= ' - El tramite legacy N° '.$partes[0].', no se encuentra ingresado en el Sistema. <br>'; 
                        Log::info(" El tramite legacy N° '.$partes[0].', no se encuentra ingresado en el Sistema", ["Modulo" => "Import:importFiles","Usuario" => Auth::user()->id.": ".Auth::user()->name]);
                    }
                } catch (\Throwable $th) {
                    $filesError++; 
                    $msgError .= 'Se ha producido un error al momento de almacenar el Archivo. '.$th->getMessage().'<br>'; 
                    Log::info('Se ha producido un error al momento de almacenar el Archivo. '.$th->getMessage().'<br>', ["Modulo" => "Import:importFiles","Usuario" => Auth::user()->id.": ".Auth::user()->name]);
                }

            }            
            $retorno = 'PROCESO DE IMPORTADOR DE ARCHIVOS FINALIZADO <br>';
            $retorno .= '=====================================<br>';
            $retorno .= 'Se han procesado un total de '.strval($files).' archivos <br>';
            $retorno .= 'Se ha registrado un total de '.strval($filesSuccess). ' registros correctamente <br>';
            $retorno .= 'Se ha registrado un total de '.strval($filesDuplicados). ' registros duplicados <br>';
            $retorno .= 'Se ha registrado un total de '.strval($filesError). ' registros con errores <br>';
            
            if($msgError != ''){
                $retorno .= '<br>Registros con Errores<br>';
                $retorno .= '=====================================<br>';
                $retorno .= $msgError;
            }

            if($msgDuplidados != ''){
                $retorno .= '<br>Registros Duplicados<br>';
                $retorno .= '=====================================<br>';
                $retorno .= $msgDuplidados;
            }

            return response()->json(['message' => 'Se ha finalizado el proceso de importacion de Estados.', 'status' => $retorno], 200);
        }
    }
