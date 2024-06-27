<?php

namespace App\Http\Controllers\Manager\CentrosBarriales;

use App\Http\Controllers\Controller;
use App\Models\Manager\AcompanamientoCbj;
use App\Models\Manager\ActividadCbj;
use App\Models\Manager\AddressData;
use App\Models\Manager\AutorizacionCb;
use App\Models\Manager\CanalAtencion;
use App\Models\Manager\Comedor;
use App\Models\Manager\ContactData;
use App\Models\Manager\Cud;
use App\Models\Manager\EducationData;
use App\Models\Manager\EscuelaTurno;
use App\Models\Manager\EstadoEducativo;
use App\Models\Manager\LegajoCB;
use App\Models\Manager\Localidad;
use App\Models\Manager\NivelEducativo;
use App\Models\Manager\Person;
use App\Models\Manager\SaludData;
use App\Models\Manager\Sede;
use App\Models\Manager\TipoDocumento;
use App\Models\Manager\TipoLegajoCb;
use App\Models\Manager\TipoTramite;
use App\Models\Manager\Tramite;
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
        return Inertia::render('Manager/CentrosBarriales/Inscripciones/Index');
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
                'nivelesEducativo' => NivelEducativo::all(),
                'estadosEducativo' => EstadoEducativo::all(),
                'turnosEducativo' => EscuelaTurno::all(),
            ]
        );
    }

    //create
    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
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

            // updateOrCreate de Datos de la Direccion $person
            AddressData::updateOrCreate(
                [
                    'person_id' => $person->id
                ],
                $request->direccion
            );

            // updateOrCreate de Datos de Salud $person
            SaludData::updateOrCreate(
                [
                    'person_id' => $person->id
                ],
                $request->salud
            );

            Cud::updateOrCreate(
                [
                    'person_id' => $person->id
                ],
                $request->salud
            );

            // updateOrCreate de Datos de Salud $person
            EducationData::updateOrCreate(
                [
                    'person_id' => $person->id
                ],
                $request->educacion
            );
            
            $request->merge([
                'inscripcion' => array_merge($request->input('inscripcion', []), ['person_id' => $person->id])
            ]);

            // Registro datos de persona responsable
            if($request->responsable){
                $responsable = Person::updateOrCreate(
                    [
                        'tipo_documento_id' => $request->responsable['tipo_documento_id'],
                        'num_documento' => $request->responsable['num_documento']
                    ],  
                    $request->responsable
                );
            }

            // Controla el Tipo de Centro Barrial.
            if($request->tipo_cb === 'Juventud'){
                $tipo_legajo_cb = TipoLegajoCb::where('description','Centro Barrial Juventud')->first();
            }else if($request->tipo_cb === 'Infancia'){
                $tipo_legajo_cb = TipoLegajoCb::where('description','Centro Barrial Infancia')->first();
            }

            // Recupero si la persona posee legajoCB
            $legajo = LegajoCB::updateOrCreate(
                [
                    'person_id' => $request->inscripcion['person_id'],
                    'fecha_inscripcion' => date("Y-m-d ", strtotime($request->inscripcion['fecha'])),
                    'fecha_inicio' => $request->inscripcion['fecha_inicio'] ?? null,
                    'observacion' => $request->inscripcion['observacion'] ?? null,
                    'responsable_id' => $responsable['id'] ?? null,
                    'tipo_legajo_id' => $tipo_legajo_cb['id']
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
            /// Obtener el id del tipo tramite Inscripcion Centros Barriales.
            $tipo_tramite = TipoTramite::where('description','INSCRIPCIÓN A CENTROS BARRIALES')->first();
            // Crear Tramite de Inscripcion
            $tramite_data = Tramite::Create(
                [
                    'fecha' => date("Y-m-d ", strtotime($request->inscripcion['fecha'])),
                    'observacion' => $request->inscripcion['observacion'] ?? '',
                    'sede_id' => $request->inscripcion['canal_atencion_id'],
                    'canal_atencion_id' => $request->inscripcion['canal_atencion_id'],
                    'tipo_tramite_id' => $tipo_tramite['id'],
                    'dependencia_id' => $tipo_tramite['dependencia_id'],

                    'estado_id' => 1 // Abierto
                ]
            );

            // Relacionar tramite con Persons.
            if(isset($responsable)){
                $person->tramites()->attach($tramite_data['id'], ['rol_tramite_id' => 1]); // ROL TITULAR
                $responsable->tramites()->attach($tramite_data['id'], ['rol_tramite_id' => 2]); // ROL BENEFICIARIO
            }else{
                $person->tramites()->attach($tramite_data['id'], ['rol_tramite_id' => 1]); // ROL TITULAR
            }

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
                'legajo' => LegajoCB::where('id',$id)->with('estadocbj', 'sede', 'responsable', 'person', 'person.contact', 'autorizacion', 'canal_atencion','person.address', 
                    'person.address.localidad','person.address.barrio','person.salud', 'person.cud', 'person.education', 'person.education.nivelEducativo', 
                    'person.education.estadoEducativo', 'person.education.escuelaTurno')->get(),                
            ]
        );
    }

}
