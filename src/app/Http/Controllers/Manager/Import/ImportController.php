<?php

namespace App\Http\Controllers\Manager\Import;

use App\Http\Controllers\Controller;
use App\Imports\DiscapacidadImport;
use App\Imports\EntidadImport;
use App\Models\Manager\Dependencia;
use App\Models\Manager\Entidad;
use Illuminate\Http\Request;
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

    public function importEntidad(Request $request)
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

    public function importDependencia(Request $request)
    {
        if( $request->file('file')){
            try {
                $archivoCSV = $request->file('file');
                
                    switch ($request['dependencia_id']) {
                        case 2:
                            $import = new DiscapacidadImport();
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
}
