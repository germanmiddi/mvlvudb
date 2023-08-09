<?php

namespace App\Http\Controllers\Manager\Masterdata;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Redirect;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use app\Models\Manager\TipoTramite;

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

    public function get_discapacidad_tipo_tramite(){

        $tipo_tramite = TipoTramite::where('dependencia_id', 2)->get();
        return response()->json($discapacidad_tipo_tramite);
        
    }

    
}
