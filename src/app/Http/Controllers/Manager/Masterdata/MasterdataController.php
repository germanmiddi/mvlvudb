<?php

namespace App\Http\Controllers\Manager\Masterdata;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Redirect;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use App\Models\Manager\TipoTramite;

class MasterdataController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index(){
        return Inertia::render('Manager/Masterdata/Index');

    }


    public function get_tipo_tramite($dependencia_id){

        $tipo_tramite = TipoTramite::where('dependencia_id', $dependencia_id)->get();
        return response()->json($tipo_tramite);
        
    }

    public function store_tipo_tramite(Request $request){
        
        $description = $request->input('description');
        $dependencia_id = $request->input('dependencia_id');
        
        if (!$description || !$dependencia_id) {
            return response()->json(['message' => 'El campo descripción es requerido'], 422);
        }

        $item = TipoTramite::create([
            'description' => $description,
            'dependencia_id' => $dependencia_id,
            'activo' => 1,
            'created_at' => Carbon::now()
        ]);

        return response()->json(['message' => 'Datos guardados correctamente'], 200);

    }

    public function update_tipo_tramite(Request $request){
        
        $itemId   = $request->input('id'); // Obtener el id del item desde la solicitud
        $itemDescription = $request->input('description'); // Obtener los datos del item desde la solicitud
        $activo = $request->input('activo'); // Obtener los datos del item desde la solicitud

        // Buscar el registro TipoTramite por su id
        $tipoTramite = TipoTramite::find($itemId);
    
        if (!$tipoTramite) {
            return response()->json(['message' => 'Registro no encontrado'], 404);
        }
    
        // Actualizar los campos del registro con los nuevos datos
        $tipoTramite->update([
            'description' => $itemDescription,
            'activo'     => $activo,
            'updated_at' => Carbon::now()
        ]);
    
        return response()->json(['message' => 'Datos actualizados correctamente'], 200);
    }

    public function hideTipoTramite(Request $request){
        
        $tipoTramite = TipoTramite::find($request->id);

        if (!$tipoTramite) {
            return response()->json(['message' => 'Registro no encontrado'], 404);
        }
        
        $tipoTramite->activo = $tipoTramite->activo == 1 ? 0 : 1;
        // dd($tipoTramite->activo);
        $tipoTramite->save();
               
        return response()->json(['message' => 'Datos actualizados correctamente'], 200);

    }

    public function destroyTipoTramite(Request $request){
            
            $tipoTramite = TipoTramite::find($request->id);
    
            if (!$tipoTramite) {
                return response()->json(['message' => 'Registro no encontrado'], 404);
            }
            $tramitesAsociados = $tipoTramite->tramites()->count();
            if ($tramitesAsociados > 0) {
                return response()->json(['message' => 'No se puede eliminar este TipoTramite porque está siendo utilizado en trámites'], 422);
            }
            $tipoTramite->delete();
                
            return response()->json(['message' => 'Datos eliminados correctamente'], 200);
    }

    // public function update_tipo_tramite(Request $request){
    //     $item = $request->input('item');
    //     dd($item);
    //     // Ahora puedes acceder a los campos del item, por ejemplo:
    //     // $description = $item->description;
    //     // dd($description);

    //     // $item->update([
    //     //     'description' => $item['description'],
    //     //     'updated_at' => Carbon::now()
    //     // ]);

    //     return response()->json(['message' => 'Datos actualizados correctamente'], 200);


    // }

    
}
