<?php

namespace App\Http\Controllers\Manager;

// use App\Models\Persona;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Manager\Entidad;
use App\Models\Manager\LegajoCB;
use App\Models\Manager\TipoLegajoCb;
use App\Models\Manager\Tramite;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        return  Inertia::render('Manager/Dashboard/Index');
    }

    public function dashboardTramites(){

        $tramites = Tramite::select('dependencia_id', DB::raw('COUNT(*) as count'))
            ->groupBy('dependencia_id')
            ->get();
        $entidades = Entidad::count();
        $data['tramites'] = $tramites;
        $data['entidades'] = $entidades;
        return ($data);
    }

    public function dashboardCBJ(){

        // Obtiene ID Tipo Legajo
        $tipoLegajo = TipoLegajoCb::where('description', 'Centro Barrial Juventud')->first();

        $data = LegajoCB::selectRaw('sede_id, COUNT(*) as total')
        ->where('tipo_legajo_id', $tipoLegajo['id'])
        ->groupBy('sede_id')
        ->get();
        return ($data);
    }

    public function dashboardCBI(){
        // Obtiene ID Tipo Legajo
        $tipoLegajo = TipoLegajoCb::where('description', 'Centro Barrial Infancia')->first();

        $data = LegajoCB::selectRaw('sede_id, COUNT(*) as total')
        ->where('tipo_legajo_id', $tipoLegajo['id'])
        ->groupBy('sede_id')
        ->get();
        return ($data);
    }

}

