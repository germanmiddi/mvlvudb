<?php

namespace App\Http\Controllers\Manager\CentrosBarriales;

use App\Http\Controllers\Controller;

use App\Models\Manager\ActividadCbj;
use App\Models\Manager\AcompanamientoCbj;
use App\Models\Manager\AddressData;
use App\Models\Manager\AditionalData;
use App\Models\Manager\AreaLegajoCB;
use App\Models\Manager\AutorizacionCb;
use App\Models\Manager\CanalAtencion;
use App\Models\Manager\CentroSalud;
use App\Models\Manager\Comedor;
use App\Models\Manager\ContactData;
use App\Models\Manager\Cud;
use App\Models\Manager\EducationData;
use App\Models\Manager\EmprendedorCB;
use App\Models\Manager\Escuela;
use App\Models\Manager\EscuelaDependencia;
use App\Models\Manager\EscuelaNivel;
use App\Models\Manager\EscuelaTurno;
use App\Models\Manager\EstadoEducativo;
use App\Models\Manager\GabineteCB;
use App\Models\Manager\LegajoCB;
use App\Models\Manager\Localidad;
use App\Models\Manager\NivelEducativo;
use App\Models\Manager\Pais;
use App\Models\Manager\Parentesco;
use App\Models\Manager\Person;
use App\Models\Manager\SaludData;
use App\Models\Manager\Sede;
use App\Models\Manager\SituacionConyugal;
use App\Models\Manager\SocialData;
use App\Models\Manager\TipoDocumento;
use App\Models\Manager\TipoLegajoCb;
use App\Models\Manager\TipoOcupacion;
use App\Models\Manager\TipoTramite;
use App\Models\Manager\Tramite;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;

class InscripcionesCBIController extends Controller
{
    protected $FamiliarConviviente = ['Madre', 'Padre', 'Abuela/o', 'Adulto/a Responsable', 'Hermana/o', 'Tia/o', 'Madrastra/Padrastro', 'Pareja Conviviente', 'Hija/o - Hijastro/a', 'Otro Familiar'];
    protected $sedesAvailables = ['Las Flores','Sivori', 'La Loma', 'El Ceibo', 'Habana'];

    public function index()
    {
        return Inertia::render('Manager/CentrosBarriales/Inscripciones/Infancia/Index',
        [
            'sedes' => Sede::whereIn('description', $this->sedesAvailables)->get(),
        ]);
    }

    public function create()
    {
        return Inertia::render('Manager/CentrosBarriales/Inscripciones/Infancia/Create',
            [
                'actividadesCbj' => ActividadCbj::where('activo', true)->get(),
                'acompanamientosCbj' => AcompanamientoCbj::where('activo', true)->get(),
                'canalesAtencion' => CanalAtencion::where('id','<>',10)->get(),
                'centrosSalud' => CentroSalud::active()->get(),
                'comedores' => Comedor::where('activo', true)->get(),
                'estadosEducativo' => EstadoEducativo::all(),
                'escuelas' => Escuela::where('primaria', true)->whereNull('dependencia_id')->get(),
                'escuelasDependencia' => EscuelaDependencia::active()->get(),
                'localidades' => Localidad::all(),
                'nivelesEducativo' => NivelEducativo::all(),
                'sedes' => Sede::whereIn('description', $this->sedesAvailables)->get(),
                'tiposDocumento' => TipoDocumento::all(),
                'tiposTramite' => TipoTramite::where('dependencia_id', 12)->active()->get(),
                'turnosEducativo' => EscuelaTurno::all(),
                'escuelasNivel' => EscuelaNivel::where('cbi', true)->get(),

                'paises' => Pais::all(),
                'parentescos' => Parentesco::whereIn('description', $this->FamiliarConviviente)->get(),
                'situacionesConyugal' => SituacionConyugal::all(),
                'tiposOcupacion' => TipoOcupacion::all(),



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

                ContactData::updateOrCreate(
                    [
                        'person_id' => $responsable['id']
                    ],
                    $request->responsable
                );
    
                AddressData::updateOrCreate(
                    [
                        'person_id' => $responsable['id']
                    ],
                    $request->responsable
                );

                EducationData::updateOrCreate(
                    [
                        'person_id' => $responsable['id']
                    ],
                    $request->responsable
                );

                AditionalData::updateOrCreate(
                    [
                        'person_id' => $responsable['id']
                    ],
                    $request->responsable
                );

                SocialData::updateOrCreate(
                    [
                        'person_id' => $responsable['id']
                    ],
                    $request->responsable
                );
    
            }

            // Obtiene ID de Tipo de Legajo.
            $tipo_legajo_cb = TipoLegajoCb::where('description','Centro Barrial Infancia')->first();
            $legajo = LegajoCB::updateOrCreate(
                [
                    'person_id' => $request->inscripcion['person_id'],
                    'fecha_inscripcion' => date("Y-m-d ", strtotime($request->inscripcion['fecha'])),
                    'fecha_inicio' => $request->inscripcion['fecha_inicio'] ?? null,
                    'observacion' => $request->inscripcion['observacion'] ?? null,
                    'responsable_id' => $responsable['id'] ?? null,
                    'parentesco_id' => $request->responsable['parentesco_id'] ?? null,
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

            if($request->gabinete){
                GabineteCB::updateOrCreate(
                    [
                        'legajo_id' => $legajo['id']
                    ],
                    $request->gabinete
                );
            }

            $tipo_tramite = TipoTramite::where('description','INSCRIPCION A CENTROS BARRIALES INFANCIA')->first();

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

            $person->tramites()->attach($tramite_data['id'], ['rol_tramite_id' => 1]); // ROL TITULAR
            //if(isset($responsable)){
                //$responsable->tramites()->attach($tramite_data['id'], ['rol_tramite_id' => 2]); // ROL BENEFICIARIO
            //}else{
            //    $person->tramites()->attach($tramite_data['id'], ['rol_tramite_id' => 1]); // ROL TITULAR
            //}

            DB::commit();
            return response()->json(['message' => 'Se generado correctamente la inscripcion CBI.'], 200);
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error("Se ha generado un error al momento de almacenar la inscripcion CBI", ["Modulo" => "IncripcionCBI:store","Usuario" => Auth::user()->id.": ".Auth::user()->name, "Error" => $th->getMessage() ]);
            return response()->json(['message' => 'Se ha producido un error al momento de almacenar la inscripcion CBI. Verifique los datos ingresados.'], 203);
        }
    }

    public function cocinero($id)
    {
        // Tramites relacionados con una Inscripcion de CB Infancia.

        // Obtiene ID de Tipo de Legajo.
        
        $tipo_legajo_cb = TipoLegajoCb::where('description','Centro Barrial Infancia')->first();

        $legajos = LegajoCB::where('tipo_legajo_id', $tipo_legajo_cb['id'])->where('id',5296)->get();
        $tipo_tramite = TipoTramite::where('description','INSCRIPCION A CENTROS BARRIALES INFANCIA')->first();

        $resultados = [];
        // Recorre listado de legajos dados de alta.
        DB::beginTransaction();
        try {
            foreach ($legajos as $legajo) {
                $tramites = Tramite::where('tipo_tramite_id', $tipo_tramite['id'])
                    ->whereIn('id', function ($query) use ($legajo) {
                        $query->select('tramite_id')
                            ->from('person_tramite')
                            ->where('person_id', $legajo->person_id);
                    })
                    ->get();
    
                if ($tramites->isNotEmpty()) {
                    $resultados[] = ['estado' => 'POSEE TRAMITE',
                                    'legajo_id' => $legajo->id, 
                                    'person_id' => $legajo->person_id, 
                                    'person' => $legajo->person->lastname.' - '.$legajo->person->name, 
                                    'num_documento' => $legajo->person->num_documento];
                } else {
                    // Verificar si se va crear el tramite.
                    if($id === '1'){
                        // Crea tramite
                        $tramite_data = Tramite::Create(
                            [
                                'fecha' => $legajo->fecha_inscripcion,
                                'observacion' => $legajo->observacion,
                                'sede_id' => $legajo->sede_id,
                                'canal_atencion_id' => $legajo->canal_atencion_id ?? 1,
                                'tipo_tramite_id' => $tipo_tramite['id'],
                                'dependencia_id' => $tipo_tramite['dependencia_id'],
            
                                'estado_id' => 1 // Estado Abierto
                            ]
                        );
                        // Busco datos del titular
                        // Verifica si posee responsable relacionado
                        $person = Person::where('id',$legajo->person_id)->first();
                        $person->tramites()->attach($tramite_data['id'], ['rol_tramite_id' => 1]); // ROL TITULAR

                        /* if($legajo->responsable_id){
                            $responsable = Person::where('id',$legajo->responsable_id)->get();
                            $responsable->tramites()->attach($tramite_data['id'], ['rol_tramite_id' => 2]); // ROL BENEFICIARIO
                        }else{

                        } */
                        $resultados[] = ['estado' => 'SE HA CREADO EL TRAMITE ID: '.$tramite_data['id'],
                                        'legajo_id' => $legajo->id, 
                                        'person_id' => $legajo->person_id, 
                                        'person' => $legajo->person->lastname.' - '.$legajo->person->name, 
                                        'num_documento' => $legajo->person->num_documento];
                    }else{
                        $resultados[] = ['estado' => 'NO POSEE TRAMITE',
                                        'legajo_id' => $legajo->id, 
                                        'person_id' => $legajo->person_id, 
                                        'person' => $legajo->person->lastname.' - '.$legajo->person->name, 
                                        'num_documento' => $legajo->person->num_documento];
                    }
                }
            }
            
            DB::commit();
            // Devolver como respuesta JSON
            return response()->json(['data' => $resultados]);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json(['data' => $th->getMessage()]);
        }
    }
}
