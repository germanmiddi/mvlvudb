<?php

namespace App\Http\Controllers\Manager\Tramites\Entidad;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;

use App\Imports\Entidad\EntidadPaticipante;

class EntidadPaticipanteImportController extends Controller
{

    public function importEntidadPaticipante(Request $request)
    {
        if ($request->file('file')) {
            try {
                $archivoCSV = $request->file('file');
                Log::info('Se ha iniciado el proceso de Importación de Participantes de Entidad.');
                $import = new EntidadPaticipante();

                Excel::import($import, $archivoCSV);
                $status = $import->getImportResult();
                return response()->json(['message' => 'Se ha finalizado el proceso de importacion de participantes.', 'result' => $status], 200);

            } catch (\Throwable $th) {
                Log::error('Error al procesar el archivo CSV.', ['error' => $th->getMessage()]);
                return response()->json(['message' => 'Error al procesar el archivo CSV.'], 203);
            }
        } else {
            return response()->json(['message' => 'Error al procesar el importador. Contacte al Administrador'], 203);
        }
    }

}
