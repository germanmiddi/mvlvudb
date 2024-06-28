<?php

namespace App\Http\Controllers\Manager\CentrosBarriales;

use App\Http\Controllers\Controller;

use App\Models\Manager\ActividadCbj;
use App\Models\Manager\AcompanamientoCbj;
use App\Models\Manager\AddressData;
use App\Models\Manager\AutorizacionCb;
use App\Models\Manager\CanalAtencion;
use App\Models\Manager\Comedor;
use App\Models\Manager\ContactData;
use App\Models\Manager\Cud;
use App\Models\Manager\EducationData;
use App\Models\Manager\Escuela;
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
        return Inertia::render('Manager/CentrosBarriales/Inscripciones/Juventud/Index');
    }

    public function create()
    {
        return Inertia::render('Manager/CentrosBarriales/Inscripciones/Juventud/Create',
            [
                'actividadesCbj' => ActividadCbj::where('activo', true)->get(),
                'acompanamientosCbj' => AcompanamientoCbj::where('activo', true)->get(),
                'canalesAtencion' => CanalAtencion::where('id','<>',10)->get(),
                'comedores' => Comedor::where('activo', true)->get(),
                'escuelas' => Escuela::where('primaria', true)->whereNull('dependencia_id')->get(),
                'estadosEducativo' => EstadoEducativo::all(),
                'localidades' => Localidad::all(),
                'nivelesEducativo' => NivelEducativo::all(),
                'sedes' => Sede::whereIn('description', $this->sedesAvailables)->get(),
                'tiposDocumento' => TipoDocumento::all(),
                'tiposTramite' => TipoTramite::where('dependencia_id', 12)->active()->get(),
                'turnosEducativo' => EscuelaTurno::all(),
            ]
        );
    }

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

            ContactData::updateOrCreate(
                [
                    'person_id' => $person->id
                ],
                $request->contact
            );

            AddressData::updateOrCreate(
                [
                    'person_id' => $person->id
                ],
                $request->direccion
            );

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

            EducationData::updateOrCreate(
                [
                    'person_id' => $person->id
                ],
                $request->educacion
            );

            $request->merge([
                'inscripcion' => array_merge($request->input('inscripcion', []), ['person_id' => $person->id])
            ]);

            if($request->responsable){
                $responsable = Person::updateOrCreate(
                    [
                        'tipo_documento_id' => $request->responsable['tipo_documento_id'],
                        'num_documento' => $request->responsable['num_documento']
                    ],
                    $request->responsable
                );
            }

            // Obtiene ID de Tipo de Legajo.
            $tipo_legajo_cb = TipoLegajoCb::where('description','Centro Barrial Juventud')->first();

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

            $request->merge([
                'autorizaciones' => array_merge($request->input('autorizaciones', []), ['legajo_id' => $legajo->id])
            ]);

            AutorizacionCb::updateOrCreate(
                [
                    'legajo_id' => $request->autorizaciones['legajo_id']
                ],
                $request->autorizaciones
            );
            $tipo_tramite = TipoTramite::where('description','INSCRIPCION A CENTROS BARRIALES JUVENTUD')->first();

            $tramite_data = Tramite::Create(
                [
                    'fecha' => date("Y-m-d ", strtotime($request->inscripcion['fecha'])),
                    'observacion' => $request->inscripcion['observacion'] ?? '',
                    'sede_id' => $request->inscripcion['canal_atencion_id'],
                    'canal_atencion_id' => $request->inscripcion['canal_atencion_id'],
                    'tipo_tramite_id' => $tipo_tramite['id'],
                    'dependencia_id' => $tipo_tramite['dependencia_id'],

                    'estado_id' => 1 // Estado Abierto
                ]
            );

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
            Log::error("Se ha generado un error al momento de almacenar la inscripcion CBJ", ["Modulo" => "IncripcionCBJ:store","Usuario" => Auth::user()->id.": ".Auth::user()->name, "Error" => $th->getMessage() ]);
            return response()->json(['message' => 'Se ha producido un error al momento de almacenar la inscripcion CBJ. Verifique los datos ingresados.'], 203);
        }
    }

}
