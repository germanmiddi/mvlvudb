<?php

namespace App\Http\Controllers\Manager\CentrosBarriales;

use App\Http\Controllers\Controller;
use App\Models\Manager\AcompanamientoCbj;
use App\Models\Manager\ActividadCbj;
use App\Models\Manager\CanalAtencion;
use App\Models\Manager\Comedor;
use App\Models\Manager\Localidad;
use App\Models\Manager\Sede;
use App\Models\Manager\TipoDocumento;
use App\Models\Manager\TipoTramite;
use Illuminate\Http\Request;
use Inertia\Inertia;

class InscripcionesCBJController extends Controller
{
    protected $sedesAvailables = ['Munro','Villa Martelli', 'La Loma', 'El Ceibo'];

    public function index()
    {
        return Inertia::render('Manager/CentrosBarriales/Inscripciones/Index',
        [
            /* 'tiposTramite' => TipoTramite::where('dependencia_id', 6)->active()->get(),
            'estados' => TramiteEstado::all(),
            'users' => User::orderBy('name')->get(),
            'toast' => Session::get('toast') */
        ]);
    }

    //create
    public function create()
    {
        return Inertia::render('Manager/CentrosBarriales/Inscripciones/Create',
            [
                /* 'paises' => Pais::all(),
                'barrios' => Barrio::all(),
                */'localidades' => Localidad::all(),
                'canalesAtencion' => CanalAtencion::where('id','<>',10)->get(),/*
                'coberturasMedica' => CoberturaMedica::all(),
                'estadosEducativo' => EstadoEducativo::all(),
                'nivelesEducativo' => NivelEducativo::all(),
                */'tiposDocumento' => TipoDocumento::all(),/*
                'tiposOcupacion' => TipoOcupacion::all(),
                'tiposPension' => TipoPension::all(),
                'tiposVivienda' => TipoVivienda::all(),
                'situacionesConyugal' => SituacionConyugal::all(),
                'rolesTramite' => RolTramite::all(),
                */'tiposTramite' => TipoTramite::where('dependencia_id', 13)->active()->get(),/*
                'programasSocial' => ProgramaSocial::all(),
                'parentescos' => Parentesco::whereNotIn('description', $this->notFamiliares)->get(),
                'categories' => Category::where('dependencia_id', 6)->get(),
                'modalidadesAtencion' => ModalidadAtencion::all(), */
                'sedes' => Sede::whereIn('description', $this->sedesAvailables)->get(),
                'comedores' => Comedor::where('activo', true)->get(),
                'actividadesCbj' => ActividadCbj::where('activo', true)->get(),
                'acompanamientosCbj' => AcompanamientoCbj::where('activo', true)->get(),
            ]
        );
    }

    public function index_inscriptos()
    {
        return Inertia::render('Manager/CentrosBarriales/ListaInscriptos/Index',
        [
            /* 'tiposTramite' => TipoTramite::where('dependencia_id', 6)->active()->get(),
            'estados' => TramiteEstado::all(),
            'users' => User::orderBy('name')->get(),
            'toast' => Session::get('toast') */
        ]);
    }
}
