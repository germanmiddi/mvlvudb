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
use App\Models\Manager\Dependencia;
use App\Models\Manager\Entidad;
use App\Models\Manager\Tramite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
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

}
