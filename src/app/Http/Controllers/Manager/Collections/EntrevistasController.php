<?php

namespace App\Http\Controllers\Manager\Collections;

use App\Http\Controllers\Controller;
use Inertia\Inertia;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

//Models
use App\Models\Manager\Person;
use App\Models\Manager\Pais;
use App\Models\Manager\Barrio;
use App\Models\Manager\Localidad;
use App\Models\Manager\CanalAtencion;
use App\Models\Manager\CoberturaMedica;
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
use App\Models\Manager\Dependencia;
use App\Models\Manager\Tramite;

use App\Models\Manager\AditionalData;
use App\Models\Manager\AddressData;
use App\Models\Manager\ContactData;
use App\Models\Manager\SocialData;
use App\Models\Manager\CajasEntrevista;
use App\Models\Manager\CajasEntrevistasStatus;
use App\Models\Manager\PuntoEntrega;
use App\Models\User;
use App\Models\Manager\EducationData;

class EntrevistasController extends Controller
{
    public function index()
    {
        return Inertia::render('Manager/Collections/Entrevistas/List', [
            'estados' => CajasEntrevistasStatus::all(),
            'sedes' => PuntoEntrega::all(),
            'entrevistadores' => User::whereHas('puntosEntrega')->get()
        ]);
    }

    public function create()
    {
        return Inertia::render(
            'Manager/Collections/Entrevistas/Create',
            [
                'paises' => Pais::all(),
                'barrios' => Barrio::all(),
                'localidades' => Localidad::all(),
                'canalesAtencion' => CanalAtencion::where('id', '<>', 10)->get(),
                'coberturasMedica' => CoberturaMedica::all(),
                'estadosEducativo' => EstadoEducativo::all(),
                'nivelesEducativo' => NivelEducativo::all(),
                'tiposDocumento' => TipoDocumento::all(),
                'tiposOcupacion' => TipoOcupacion::all(),
                'tiposPension' => TipoPension::all(),
                'tiposVivienda' => TipoVivienda::all(),
                'situacionesConyugal' => SituacionConyugal::all(),
                'rolesTramite' => RolTramite::all(),
                'tiposTramite' => TipoTramite::where('dependencia_id', 5)->active()->get(),
                'programasSocial' => ProgramaSocial::all(),
                'puntosEntrega' => PuntoEntrega::all(),
                'entrevistadores' => User::whereHas('puntosEntrega')->get()
            ]
        );
    }


    public function store(Request $request)
    {
        DB::beginTransaction();
        try {

            // * DNI
            // * Nombre y Apellido
            // * Fecha de Nacimiento
            $person = Person::updateOrCreate(
                [
                    'tipo_documento_id' => $request['tipo_documento_id'],
                    'num_documento' => $request['num_documento']
                ],
                [
                    'lastname' => $request['lastname'],
                    'name' => $request['name'],
                    'fecha_nac' => $request['fecha_nac'],
                    'tipo_documento_id' => $request['tipo_documento_id'],
                    'num_documento' => $request['num_documento']
                ]
            );

            $aditionalData = AditionalData::updateOrCreate(
                [
                    'person_id' => $person->id
                ],
                [
                    'cant_hijos' => $request['cant_hijos'],
                    'situacion_conyugal_id' => $request['situacion_conyugal_id'],
                    'nacionalidad' => $request['pais_id'],
                ]
            );

            AddressData::updateOrCreate(
                [
                    'person_id' => $person->id
                ],
                [
                    'calle' => $request['calle'],
                    'number' => $request['number'],
                    'piso' => $request['piso'],
                    'dpto' => $request['dpto'],
                    'latitude' => $request['latitude'],
                    'longitude' => $request['longitude'],
                    'google_address' => $request['google_address'],
                    'pais_id' => $request['pais_id'],
                    'localidad_id' => $request['localidad_id'],
                    'barrio_id' => $request['barrio_id'],
                ]
            );

            ContactData::updateOrCreate(
                [
                    'person_id' => $person->id
                ],
                [
                    'phone' => $request['phone'],
                    'celular' => $request['celular'],
                    'email' => $request['email']
                ]
            );

            SocialData::updateOrCreate(
                [
                    'person_id' => $person->id
                ],
                [
                    'tipo_ocupacion_id' => $request['tipo_ocupacion_id'],
                    'cobertura_medica_id' => $request['cobertura_medica_id'],
                    'tipo_pension_id' => $request['tipo_pension_id'],
                    'programa_social_id' => $request['programa_social_id']
                ]
            );

            $selectedPrograms = explode(',', $request['selected_programs']);
            $person->programaSocial()->sync($selectedPrograms);

            EducationData::updateOrCreate(
                [
                    'person_id' => $person->id
                ],
                [
                    'nivel_educativo_id' => $request['nivel_educativo_id'],
                    'estado_educativo_id' => $request['estado_educativo_id']
                ]
            );

            $status_pendiente = CajasEntrevistasStatus::where('nombre', 'PENDIENTE')->first()->id;

            $entrevista = CajasEntrevista::updateOrCreate(
                ['person_id' => $person->id],
                [
                    'fecha' => $request['fecha_entrevista'],
                    'entrevistador_id' => $request['entrevistador_id'],
                    'puntos_entrega_id' => $request['sede_id'],
                    'status_id' => $status_pendiente,
                    'created_by' => Auth::user()->id,

                    'vive_solo' => $request['vive_solo'],
                    'cant_convivientes' => $request['cant_convivientes'],
                    'tenencia' => $request['tenencia'],
                    'pago_inquilino' => $request['pago_inquilino'],
                    'ambientes' => $request['ambientes'],
                    'ingresos_trabajo' => $request['ingresos_trabajo'],
                    'ingresos_planes' => $request['ingresos_planes'],
                    // 'tratamiento_medico' => $request['tratamiento_medico'],
                    // 'medicacion' => $request['medicacion'],
                    // 'discapacidad' => $request['discapacidad']
                ]
            );

            $entrevista->save();

            DB::commit();
            Log::info('Entrevista creada correctamente', ["Usuario" => Auth::user()->id . ": " . Auth::user()->name, "Entrevista" => $entrevista->id]);
            return response()->json(['message' => 'Entrevista creada correctamente'], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error al crear la entrevista', ["Usuario" => Auth::user()->id . ": " . Auth::user()->name, "Error" => $e->getMessage()]);
            return response()->json(['message' => $e->getMessage()], 500);
        }

    }

    public function list()
    {
        $length = 10;

        $entrevistas = CajasEntrevista::query();

        if (request('name')) {
            $name = request('name');
            $entrevistas->whereHas('person', function ($query) use ($name) {
                $query->where('name', 'LIKE', '%' . $name . '%')
                    ->orWhere('lastname', 'LIKE', '%' . $name . '%');
            });
        }

        if (request('num_documento')) {
            $num_documento = request('num_documento');
            // dd($num_documento);
            $entrevistas->whereHas('person', function ($query) use ($num_documento) {
                $query->where('num_documento', $num_documento);
            });
        }

        if (request('date')) {
            $date = json_decode(request('date'));

            $from = date('Y-m-d', strtotime($date[0]));
            $to = date('Y-m-d', strtotime("+1 day", strtotime($date[1])));

            $entrevistas->where('fecha', '>=', $from)
                ->where('fecha', '<', $to);
        }

        if (request('estado')) {
            $estado = request('estado');
            $entrevistas->where('status_id', $estado);
        }

        if (request('punto_entrega_id')) {
            $punto_entrega_id = request('punto_entrega_id');
            $entrevistas->where('puntos_entrega_id', $punto_entrega_id);
        }

        if (request('entrevistador_id')) {
            $entrevistador_id = request('entrevistador_id');
            $entrevistas->where('entrevistador_id', $entrevistador_id);
        }


        return $entrevistas
            ->orderBy('fecha', 'DESC')
            ->paginate($length)
            ->withQueryString()
            ->through(fn($entrevista) => [
                'id' => $entrevista->id,
                'fecha' => $entrevista->fecha,
                'person' => $entrevista->person->lastname . ', ' . $entrevista->person->name,
                'num_documento' => $entrevista->person->num_documento,
                'entrevistador' => $entrevista->entrevistador,
                'puntosEntrega' => $entrevista->puntosEntrega,
                'status' => $entrevista->status,
                'status_id' => $entrevista->status_id
            ]);

    }

    public function edit($id)
    {
        // return Inertia::render('Manager/Collections/Entrevistas/Edit', ['id' => $id]);
    }

    public function view($id)
    {
        return Inertia::render(
            'Manager/Collections/Entrevistas/Details',
            [
                'entrevista' => CajasEntrevista::where('id', $id)
                    ->with('person.address')
                    ->with('person.contact')
                    ->with('person.aditional')
                    ->with('person.social')
                    ->with('person.education')
                    ->with('person.programaSocial')
                    ->first()
            ]
        );
    }
    public function delete($id)
    {
        // return Inertia::render('Manager/Collections/Entrevistas/Delete', ['id' => $id]);
    }

    public function update(Request $request)
    {
        DB::beginTransaction();
        try {

            $status_aprobada = CajasEntrevistasStatus::where('nombre', 'APROBADA')->first()->id;
            // dd($status_aprobada, $request['status_id']);

            $entrevista = CajasEntrevista::where('id', $request['id'])->first();
            $entrevista->status_id = $request['status_id'];
            $entrevista->status_updated_by = Auth::user()->id;
            $entrevista->status_updated_at = date('Y-m-d H:i:s');
            $entrevista->save();

            if (intval($request['status_id']) == intval($status_aprobada)) {
                $this->_createTramite($entrevista);
            }

            DB::commit();
            Log::info(
                'Estado de la entrevista actualizado correctamente',
                [
                    "Usuario" => Auth::user()->id . ": " . Auth::user()->name,
                    "Estado" => $entrevista->status->nombre,
                    "Entrevista" => $entrevista->id
                ]
            );
            return response()->json(['message' => 'Estado actualizado correctamente'], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error al actualizar el estado de la entrevista', ["Usuario" => Auth::user()->id . ": " . Auth::user()->name, "Error" => $e->getMessage()]);
            return response()->json(['message' => $e->getMessage()], 500);
        }

    }

    public function _createTramite($entrevista)
    {

        DB::beginTransaction();
        try {

            $canal_atencion_id = CanalAtencion::where('description', 'SEC. DESARROLLO SOCIAL - SEDE YRIGOYEN')->first()->id;
            $dependencia_id = Dependencia::where('description', 'FORTALECIMIENTO COMUNITARIO')->first()->id;
            $tipo_tramite_id = TipoTramite::where('description', 'EMPADRONAMIENTO CAJAS')->first()->id;

            $tramite_data = Tramite::Create(
                [
                    'fecha' => date("Y-m-d ", strtotime($entrevista->fecha)),
                    'canal_atencion_id' => $canal_atencion_id,
                    'tipo_tramite_id' => $tipo_tramite_id,
                    'dependencia_id' => $dependencia_id,
                    'estado_id' => 1, // Estado Abierto
                ]
            );

            $entrevista->person->tramites()->attach($tramite_data['id'], ['rol_tramite_id' => 1]); // ROL TITULAR

            DB::commit();
            Log::info("Se ha creado un nuevo tramite", ["Modulo" => "Entrevistas:createTramite", "Usuario" => Auth::user()->id . ": " . Auth::user()->name, "ID Tramite" => $tramite_data['id']]);

            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error al crear el tramite', ["Usuario" => Auth::user()->id . ": " . Auth::user()->name, "Error" => $e->getMessage()]);
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

}
