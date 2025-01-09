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
        return Inertia::render('Manager/Collections/Entrevistas/List');
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

            SocialData::where('person_id', $request['person_id'])->update(
                [
                    'tipo_ocupacion_id' => $request['tipo_ocupacion_id'],
                    'cobertura_medica_id' => $request['cobertura_medica_id'],
                    'tipo_pension_id' => $request['tipo_pension_id'],
                    'programa_social_id' => $request['programa_social_id']
                ]
            );

            EducationData::where('person_id', $request['person_id'])->update(
                [
                    'nivel_educativo_id' => $request['nivel_educativo_id'],
                    'estado_educativo_id' => $request['estado_educativo_id']
                ]
            );

            $status_pendiente = CajasEntrevistasStatus::where('nombre', 'PENDIENTE')->first()->id;

            $entrevista = CajasEntrevista::updateOrCreate(
                [ 'person_id' => $person->id], 
                [
                'fecha' => $request['fecha_entrevista'],
                'entrevistador_id' => $request['entrevistador_id'],
                'puntos_entrega_id' => $request['sede_id'],
                'status_id' => $status_pendiente,
                'created_by' => Auth::user()->id,
                // 'estudios' => $request['estudios'],
                'vive_solo' => $request['vive_solo'],
                'cant_convivientes' => $request['cant_convivientes'],
                'tenencia' => $request['tenencia'],
                'pago_inquilino' => $request['pago_inquilino'],
                'ambientes' => $request['ambientes'],
                // 'trabajo' => $request['trabajo'],
                // 'ingresos_trabajo' => $request['ingresos_trabajo'],
                // 'otra_actividad' => $request['otra_actividad'],
                // 'tiene_pami' => $request['tiene_pami'],
                // 'tiene_obra_social' => $request['tiene_obra_social'],
                // 'obra_social' => $request['obra_social'],
                // 'tratamiento_medico' => $request['tratamiento_medico'],
                // 'medicacion' => $request['medicacion'],
                // 'discapacidad' => $request['discapacidad']
            ]);

            $entrevista->save();

            DB::commit();
            Log::info('Entrevista creada correctamente', ["Usuario" => Auth::user()->id . ": " . Auth::user()->name, "Entrevista" => $entrevista->id]);
            return response()->json(['message' => 'Entrevista creada correctamente'], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error al crear la entrevista', ["Usuario" => Auth::user()->id . ": " . Auth::user()->name, "Error" => $e->getMessage()]);
            return response()->json(['message' => $e->getMessage()], 500);
        }

        // return Inertia::render('Manager/Collections/Entrevistas/List');
    }

    public function list()
    {

        $length = 10;

        return CajasEntrevista::query()
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
        try{
            $entrevista = CajasEntrevista::where('id', $request['id'])->first();
            $entrevista->status_id = $request['status_id'];
            $entrevista->status_updated_by = Auth::user()->id;
            $entrevista->status_updated_at = date('Y-m-d H:i:s');
            $entrevista->save();
            DB::commit();
            Log::info('Estado de la entrevista actualizado correctamente',
                [
                    "Usuario" => Auth::user()->id . ": " . Auth::user()->name,
                    "Estado" => $entrevista->status->nombre,
                    "Entrevista" => $entrevista->id
                ]
            );
            return response()->json(['message' => 'Estado actualizado correctamente'], 200);
        }
        catch(\Exception $e){
            DB::rollBack();
            Log::error('Error al actualizar el estado de la entrevista', ["Usuario" => Auth::user()->id . ": " . Auth::user()->name, "Error" => $e->getMessage()]);
            return response()->json(['message' => $e->getMessage()], 500);
        }
       
    }

}
