<?php

namespace App\Http\Controllers\Manager\Tramites\Genero;

use App\Http\Controllers\Controller;
use App\Models\Manager\AddressData;
use App\Models\Manager\AditionalData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Inertia\Inertia;

//Models
use App\Models\Manager\Pais;
use App\Models\Manager\Barrio;
use App\Models\Manager\Localidad;
use App\Models\Manager\CanalAtencion;
use App\Models\Manager\CoberturaMedica;
use App\Models\Manager\ContactData;
use App\Models\Manager\Cud;
use App\Models\Manager\EducationData;
use App\Models\Manager\EstadoEducativo;
use App\Models\Manager\NivelEducativo;
use App\Models\Manager\TipoDocumento;
use App\Models\Manager\TipoOcupacion;
use App\Models\Manager\TipoPension;
use App\Models\Manager\TipoVivienda;
use App\Models\Manager\SituacionConyugal;
use App\Models\Manager\RolTramite;
use App\Models\Manager\TipoTramite;
use App\Models\Manager\ProgramaSocial;
use App\Models\Manager\Person;
use App\Models\Manager\SocialData;
use App\Models\Manager\Tramite;
use Illuminate\Support\Facades\Redirect;

class GeneroController extends Controller
{
    //index

    public function index()
    {
        return Inertia::render('Manager/Tramites/Genero/Index',
        [
            'toast' => Session::get('toast')
        ]);
    }
    //create
    public function create()
    {
        return Inertia::render(
            'Manager/Tramites/Genero/Create',
            [
                'paises' => Pais::all(),
                'barrios' => Barrio::all(),
                'localidades' => Localidad::all(),
                'canalesAtencion' => CanalAtencion::all(),
                'coberturasMedica' => CoberturaMedica::all(),
                'estadosEducativo' => EstadoEducativo::all(),
                'nivelesEducativo' => NivelEducativo::all(),
                'tiposDocumento' => TipoDocumento::all(),
                'tiposOcupacion' => TipoOcupacion::all(),
                'tiposPension' => TipoPension::all(),
                'tiposVivienda' => TipoVivienda::all(),
                'situacionesConyugal' => SituacionConyugal::all(),
                'rolesTramite' => RolTramite::all(),
                'tiposTramite' => TipoTramite::where('dependencia_id', 6)->get(),
                'programasSocial' => ProgramaSocial::all()
            ]
        );
    }
    //store
    public function store(Request $request)
    {
        
    }
    //show
    public function show($id)
    {
        //
    }
    //edit
    public function edit($id)
    {
        //
    }
    //update
    public function update(Request $request, $id)
    {
        //
    }
    //destroy
    public function destroy($id)
    {
        //
    }
    //list
    public function list()
    {
        
    }
}

