<?php

namespace App\Http\Controllers\Manager\CentrosBarriales;

use App\Http\Controllers\Controller;
use App\Models\Manager\EstadoCbj;
use App\Models\Manager\EstadoProgramaSocialCb;
use App\Models\Manager\LegajoCB;
use App\Models\Manager\ProgramaSocialCB;
use App\Models\User;
use App\Models\Manager\TipoLegajoCb;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class LegajosCBController extends Controller
{
    public function index()
    {
        return Inertia::render('Manager/CentrosBarriales/Legajos/Index',
        [
            'tiposLegajo' => TipoLegajoCb::all(),
            'estados' => EstadoCbj::all(),
        ]);
    }

    public function legajo($id)
    {
        return Inertia::render('Manager/CentrosBarriales/Legajos/Legajo',
            [
                'legajo' => LegajoCB::where('id',$id)
                                    ->with('estadocbj',
                                           'sede',
                                           'responsable',
                                           'person',
                                           'person.contact',
                                           'autorizacion',
                                           'canal_atencion',
                                           'person.address',
                                           'person.address.localidad',
                                           'person.address.barrio',
                                           'person.salud',
                                           'person.cud',
                                           'person.education',
                                           'person.education.nivelEducativo',
                                           'person.education.estadoEducativo',
                                           'person.education.escuelaTurno',
                                           'tipo_legajo',
                                           'programas_sociales')->get(),
                'users' => User::all(),
                'programasSociales' => ProgramaSocialCB::all()
            ]
        );
    }

    // Store Programa Social
    public function store_programa_social(Request $request){
        try {
            $estado = EstadoProgramaSocialCb::where('description', 'Activo')->first();
            $legajo = LegajoCB::where('id', $request->legajo_id)->first();

            if (!$legajo->programas_sociales()->where('programa_social_id', $request->programa_social_id)->exists()) {
                $legajo->programas_sociales()->attach($request->programa_social_id, [
                    'profesional_id' => $request->profesional_id,
                    'fecha_inscripcion' => $request->fecha_inscripcion,
                    'estado_id' => $estado->id
                ]);
            }else{
                return response()->json(['message' => 'El programa social ya ha sido agrego previamente. Verifique los datos ingresados.'], 203);
            }
            $programas = $legajo = LegajoCB::where('id', $request->legajo_id)->with('programas_sociales')->get();
            return response()->json(['message' => 'Se registrado correctamente la el Programa Social.', 'programas' => $programas], 200);
        } catch (\Throwable $th) {
            return response()->json(['message' => 'Se ha producido un error al momento de almacenar la inscripcion CBJ. Verifique los datos ingresados.'], 203);
        }
    }

    public function list()
    {
        $length = request('length');

        $result = LegajoCB::query();

        if(request('name')){
            $name = json_decode(request('name'));
            $result->whereIn('id', function ($sub) use($name) {
                        $sub->selectRaw('legajos_cb.id')
                            ->from('legajos_cb')
                            ->join('person', 'person.id', '=', 'legajos_cb.person_id')
                            ->where('person.name', 'LIKE', '%'.$name.'%')
                            ->orWhere('person.lastname', 'LIKE', '%'.$name.'%');
                    });
        }

        if(request('num_documento')){
            $num_documento = json_decode(request('num_documento'));
            $result->whereIn('id', function ($sub) use($num_documento) {
                        $sub->selectRaw('legajos_cb.id')
                            ->from('legajos_cb')
                            ->join('person', 'person.id', '=', 'legajos_cb.person_id')
                            ->where('person.num_documento', 'LIKE', '%'.$num_documento.'%');
                    });
        }

        if(request('date')){
            $date = json_decode(request('date'));

            $from = date('Y-m-d', strtotime($date[0]));
            $to = date('Y-m-d', strtotime("+1 day", strtotime($date[1])));
            $result->where('fecha_inscripcion','>=', $from)
                    ->where('fecha_inscripcion', '<', $to);
        }

        if(request('estado_id')){
            $estado_id = json_decode(request('estado_id'));
            $result->where('estado_id', $estado_id);
        }

        if(request('tipo_legajo_id')){
            $tipo_legajo_id = json_decode(request('tipo_legajo_id'));
            $result->where('tipo_legajo_id', $tipo_legajo_id);
        }

        return  $result->with('person','sede', 'estadocbj', 'tipo_legajo')
            ->orderBy("legajos_cb.id", 'DESC')
            ->paginate($length)
            ->withQueryString();
    }
}
