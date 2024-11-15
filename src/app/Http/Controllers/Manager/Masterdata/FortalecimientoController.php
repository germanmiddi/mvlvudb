<?php

namespace App\Http\Controllers\Manager\Masterdata;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Manager\PuntoEntrega;

class FortalecimientoController extends Controller
{
    public function get_puntos_entrega(){
        $puntos_entrega = PuntoEntrega::all();
        return response()->json($puntos_entrega);
    }

    public function store_puntos_entrega(Request $request){
        $punto_entrega = new PuntoEntrega();
        $punto_entrega->description = $request->description;
        $punto_entrega->save();
        return response()->json($punto_entrega);
    }

    public function update_puntos_entrega(Request $request){
        $punto_entrega = PuntoEntrega::find($request->id);
        $punto_entrega->description = $request->description;
        $punto_entrega->save();
        return response()->json($punto_entrega);
    }

    public function hide_puntos_entrega(Request $request){
        $punto_entrega = PuntoEntrega::find($request->id);
        $punto_entrega->activo = 0;
        $punto_entrega->save();
        return response()->json($punto_entrega);    
    }

    public function destroy_puntos_entrega(Request $request){
        $punto_entrega = PuntoEntrega::find($request->id);
        $punto_entrega->delete();
        return response()->json($punto_entrega);
    }
}
