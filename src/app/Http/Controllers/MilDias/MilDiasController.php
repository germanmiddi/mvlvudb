<?php

namespace App\Http\Controllers\MilDias;

use App\Http\Controllers\Controller;
use App\Models\Manager\Sede;
use App\Models\Manager\Barrio;
use App\Models\Manager\FamiliarAntecedente;
use App\Models\Manager\Localidad;
use App\Models\Manager\MotivoBaja;
use App\Models\Manager\MotivoConsulta;
use App\Models\Manager\NivelEducativo;
use App\Models\Manager\OrigenDemanda;
use App\Models\Manager\Pais;
use App\Models\Manager\Parentesco;
use App\Models\Manager\TipoArticulacion;
use App\Models\Manager\TipoDerivacion;
use App\Models\Manager\TipoDocumento;
use App\Models\Manager\TipoEnfermedad;
use App\Models\Manager\TipoOcupacion;
use App\Models\Manager\TipoTratamiento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Inertia\Inertia;

class MilDiasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Inertia::render('Manager/CentrosBarriales/MilDias/Index',
        [
            //'tiposTramite' => TipoTramite::where('dependencia_id', 2)->active()->get(),
            //'estados' => TramiteEstado::all(),
            //'users' => User::orderBy('name')->get(),
            'toast' => Session::get('toast')
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return Inertia::render('Manager/CentrosBarriales/MilDias/Create',
            [
                'sedes' => Sede::get(),
                'barrios' => Barrio::all(),
                'sedes' => Sede::all(),
                'paises' => Pais::all(),
                'localidades' => Localidad::all(),
                'motivo_consultas' => MotivoConsulta::all(),
                'tiposDocumento' => TipoDocumento::all(),
                'parentescos' => Parentesco::all(),
                'nivelesEducativo' => NivelEducativo::all(),
                'tiposOcupacion' => TipoOcupacion::all(),

                'familarAntecedentes' => FamiliarAntecedente::all(),
                'motivoBajas' => MotivoBaja::all(),
                'origenDemandas' => OrigenDemanda::all(),
                'tipoArticulaciones' => TipoArticulacion::all(),
                'tipoDerivaciones' => TipoDerivacion::all(),
                'tipoEnfermedades' => TipoEnfermedad::all(),
                'tipoTratamientos' => TipoTratamiento::all(),


                /*
                'canalesAtencion' => CanalAtencion::where('id','<>',10)->get(),
                'coberturasMedica' => CoberturaMedica::all(),
                'estadosEducativo' => EstadoEducativo::all(),
                'tiposPension' => TipoPension::all(),
                'tiposVivienda' => TipoVivienda::all(),
                'situacionesConyugal' => SituacionConyugal::all(),
                'rolesTramite' => RolTramite::all(),
                'tiposTramite' => TipoTramite::where('dependencia_id', 9)->get(),
                'programasSocial' => ProgramaSocial::all() */
            ]
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        dd($request);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
