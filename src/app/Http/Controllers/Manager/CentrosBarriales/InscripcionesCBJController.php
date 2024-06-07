<?php

namespace App\Http\Controllers\Manager\CentrosBarriales;

use App\Http\Controllers\Controller;
use App\Models\Manager\AcompanamientoCbj;
use App\Models\Manager\ActividadCbj;
use App\Models\Manager\AutorizacionCb;
use App\Models\Manager\CanalAtencion;
use App\Models\Manager\Comedor;
use App\Models\Manager\ContactData;
use App\Models\Manager\LegajoCB;
use App\Models\Manager\Localidad;
use App\Models\Manager\Person;
use App\Models\Manager\Sede;
use App\Models\Manager\TipoDocumento;
use App\Models\Manager\TipoTramite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
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
                'localidades' => Localidad::all(),
                'canalesAtencion' => CanalAtencion::where('id','<>',10)->get(),
                'tiposDocumento' => TipoDocumento::all(),
                'tiposTramite' => TipoTramite::where('dependencia_id', 13)->active()->get(),
                'sedes' => Sede::whereIn('description', $this->sedesAvailables)->get(),
                'comedores' => Comedor::where('activo', true)->get(),
                'actividadesCbj' => ActividadCbj::where('activo', true)->get(),
                'acompanamientosCbj' => AcompanamientoCbj::where('activo', true)->get(),
            ]
        );
    }

    //create
    public function store(Request $request)
    {
        //dd($request->autorizaciones);
        DB::beginTransaction();
        try {
            //dd($request->person);
            // updateOrCreate de $person = Person
            $person = Person::updateOrCreate(
                [
                    'tipo_documento_id' => $request->person['tipo_documento_id'],
                    'num_documento' => $request->person['num_documento']
                ],  
                $request->person
            );

            // updateOrCreate de Datos de contacto $person
            ContactData::updateOrCreate(
                [
                    'person_id' => $person->id
                ],
                $request->contact
            );
            
            $request->merge([
                'inscripcion' => array_merge($request->input('inscripcion', []), ['person_id' => $person->id])
            ]);

            // updateOrCreate de $legajo = Legajo($person.id)
            $legajo = LegajoCB::updateOrCreate(
                [
                    'person_id' => $request->inscripcion['person_id']
                ],
                $request->inscripcion
            );
            // Agrego legajo al array de autorizaciones.
            $request->merge([
                'autorizaciones' => array_merge($request->input('autorizaciones', []), ['legajo_id' => $legajo->id])
            ]);

            // Update o create Autorizaciones CB
            AutorizacionCb::updateOrCreate(
                [
                    'legajo_id' => $request->autorizaciones['legajo_id']
                ],
                $request->autorizaciones
            );
            // Crear Tramite de Inscripcion

            // Relacionar tramite con Persons.


            DB::commit();
            return response()->json(['message' => 'Se generado correctamente la inscripcion CBJ.'], 200);
        } catch (\Throwable $th) {
            dd($th);
            DB::rollBack();
            Log::error("Se ha generado un error al momento de almacenar la inscripcion", ["Modulo" => "IncripcionCBJ:store","Usuario" => Auth::user()->id.": ".Auth::user()->name, "Error" => $th->getMessage() ]);
            return response()->json(['message' => 'Se ha producido un error al momento de almacenar la inscripcion. Verifique los datos ingresados.'], 203);
        }

    }

    public function index_inscriptos()
    {
        return Inertia::render('Manager/CentrosBarriales/ListaInscriptos/Index',
        [
            'legajos' => LegajoCB::with('person','sede', 'estadocbj')->get()
        ]);
    }

    public function view_inscripto_cb($id){
        $legajo = LegajoCB::find($id);

        return Inertia::render('Manager/CentrosBarriales/ListaInscriptos/Details',
            [   
                'legajo' => LegajoCB::where('id',$id)->with('estadocbj', 'sede', 'person', 'person.contact', 'autorizacion')->get(),                
            ]
        );
    }
}
