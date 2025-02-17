<?php

namespace App\Http\Controllers\Manager\Masterdata;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Manager\PuntoEntrega;
use App\Models\Manager\Product;

class FortalecimientoController extends Controller
{
    public function get_puntos_entrega()
    {
        $puntos_entrega = PuntoEntrega::all();
        return response()->json($puntos_entrega);
    }

    public function store_puntos_entrega(Request $request)
    {
        $punto_entrega = new PuntoEntrega();
        $punto_entrega->description = $request->description;
        $punto_entrega->save();
        return response()->json($punto_entrega);
    }

    public function update_puntos_entrega(Request $request)
    {
        $punto_entrega = PuntoEntrega::find($request->id);
        $punto_entrega->description = $request->description;
        $punto_entrega->save();
        return response()->json($punto_entrega);
    }

    public function hide_puntos_entrega(Request $request)
    {
        $punto_entrega = PuntoEntrega::find($request->id);
        $punto_entrega->activo = $punto_entrega->activo == 1 ? 0 : 1;
        $punto_entrega->save();
        return response()->json($punto_entrega);
    }

    public function destroy_puntos_entrega(Request $request)
    {
        $punto_entrega = PuntoEntrega::find($request->id);
        $punto_entrega->delete();
        return response()->json($punto_entrega);
    }


    public function get_productos()
    {
        $productos = Product::all();
        return response()->json($productos);
    }
    public function update_productos(Request $request)
    {
        $producto = Product::find($request->id);
        $producto->description = $request->description;
        $producto->save();
        return response()->json($producto);
    }


    public function store_productos(Request $request)
    {
        $producto = new Product();
        $producto->name = $request->name;
        $producto->description = $request->description;
        $producto->is_active = 1;
        $producto->save();
        return response()->json($producto);
    }

    public function destroy_productos(Request $request)
    {
        $producto = Product::find($request->id);
        $producto->delete();
        return response()->json($producto);
    }

}
