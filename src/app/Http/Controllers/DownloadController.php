<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Manager\Dependencia;


class DownloadController extends Controller
{
    public function index(){

        $dependencies = Dependencia::where('activo', '=', 1)->get();

        return Inertia::render('Manager/Downloads/Index', ['dependencias' => $dependencies,]);
    }

    public function getfieldsItems($dependencia)
    {
        // return 1;
        // if ($dependencia == 2){
        //     return[ ['name' => 'N tramite', 'id' => 0],
        //     ['name' => 'Boton antipanico', 'id' => 1],
        //     ['name' => 'Nombre', 'id' => 2] ];
        // }else {
        //     return ['4', '5', '6'];
        // }
    }
}
