<?php

namespace App\Http\Controllers\Manager\CentrosBarriales;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Manager\Uploads\FileController;
use App\Models\Manager\ActividadCB;
use App\Models\Manager\ArchivoLegajo;
use App\Models\Manager\AreaLegajoCB;
use App\Models\Manager\CanalAtencion;
use App\Models\Manager\EstadoActividadCB;
use App\Models\Manager\EstadoCbj;
use App\Models\Manager\EstadoInformeCB;
use App\Models\Manager\EstadoProgramaSocialCB;
use App\Models\Manager\InformeCB;
use App\Models\Manager\IntervencionProgramaSocialCB;
use App\Models\Manager\LegajoCB;
use App\Models\Manager\Localidad;
use App\Models\Manager\LegajoProgramaSocialCB;
use App\Models\Manager\ProgramaSocialCB;
use App\Models\Manager\Sede;
use App\Models\User;
use App\Models\Manager\TipoLegajoCb;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class LegajosCBController extends Controller
{
    public function index()
    {
        return Inertia::render(
            'Manager/CentrosBarriales/Legajos/Index',
            [
                'tiposLegajo' => TipoLegajoCb::all(),
                'estados' => EstadoCbj::all()
            ]
        );
    }

    public function legajo($id)
    {
        return Inertia::render(
            'Manager/CentrosBarriales/Legajos/Legajo',
            [
                'legajo' => LegajoCB::where('id', $id)
                    ->with(
                        'estadocbj',
                        'sede',
                        'responsable',
                        'responsable.contact',
                        'responsable.social',
                        'responsable.social.tipoOcupacion',
                        'responsable.aditional',
                        'responsable.aditional.situacionConyugal',
                        'responsable.education',
                        'responsable.education.nivelEducativo',
                        'responsable.education.estadoEducativo',
                        'responsable.address',
                        'responsable.address.pais',
                        'person',
                        'person.contact',
                        'autorizacion',
                        'canal_atencion',
                        'person.address',
                        'person.address.localidad',
                        'person.address.barrio',
                        'person.salud',
                        'person.salud.centroSalud',
                        'person.cud',
                        'person.education',
                        'person.education.nivelEducativo',
                        'person.education.estadoEducativo',
                        'person.education.escuelaTurno',
                        'person.education.escuelaDependencia',
                        'person.education.escuelaLocalidad',
                        'person.education.escuelaNivel',
                        'tipo_legajo',
                        'programas_sociales',
                        'programas_sociales.profesional',
                        'programas_sociales.programa_social',
                        'programas_sociales.estado',
                        'programas_sociales.intervenciones',
                        'programas_sociales.intervenciones.profesional',
                        'actividades',
                        'informes',
                        'informes.profesional',
                        'informes.estado',
                        'informes.area',
                        'archivos',
                        'archivos.area',
                        'parentesco',
                        'gabinete',
                        'gabinete.estado',
                        'emprendedor'
                    )->get(),
                'users' => User::all(),
                'programasSociales' => ProgramaSocialCB::all(),
                'actividades' => ActividadCB::all(),
                'areas' => AreaLegajoCB::active()->get(),
                'localidades' => Localidad::all(),
                'sedes' => Sede::all(),
                'canalesAtencion' => CanalAtencion::all(),
                'tiposLegajo' => TipoLegajoCb::all(),
                'estados' => EstadoCbj::all()

            ]
        );
    }

    // Store Programa Social
    public function store_programa_social(Request $request)
    {
        try {
            $estado = EstadoProgramaSocialCB::where('description', 'Activo')->first();
            $legajo = LegajoCB::where('id', $request->legajo_id)->first();

            // Control de la existencia del programa social asociado al legajo.
            if (!LegajoProgramaSocialCB::where('programa_social_id', $request->programa_social_id)->where('legajo_id', $legajo->id)->where('estado_id', $estado->id)->exists()) {
                LegajoProgramaSocialCB::Create(
                    [
                        'legajo_id' => $legajo->id,
                        'programa_social_id' => $request->programa_social_id,
                        'profesional_id' => $request->profesional_id,
                        'fecha_inscripcion' => $request->fecha_inscripcion,
                        'estado_id' => $estado->id
                    ]
                );
            } else {
                return response()->json(['message' => 'El programa social ya ha sido agrego previamente o se encuentra activo. Verifique los datos ingresados.'], 203);
            }

            $programas = LegajoCB::where('id', $request->legajo_id)->with(
                'programas_sociales',
                'programas_sociales.profesional',
                'programas_sociales.programa_social',
                'programas_sociales.estado',
                'programas_sociales.intervenciones',
                'programas_sociales.intervenciones.profesional'
            )->get();

            return response()->json(['message' => 'Se registrado correctamente la el Programa Social.', 'programas' => $programas], 200);
        } catch (\Throwable $th) {
            dd($th);
            return response()->json(['message' => 'Se ha producido un error al momento de almacenar la inscripcion CBJ. Verifique los datos ingresados.'], 203);
        }
    }

    public function store_intervencion(Request $request)
    {
        try {
            $intervencion = IntervencionProgramaSocialCB::Create(
                [
                    'description' => $request->description,
                    'fecha' => $request->fecha_intervencion,
                    'profesional_id' => $request->profesional_id,
                    'legajo_programa_social_cb_id' => $request->programa_social_id,
                ]
            );

            $programas = LegajoProgramaSocialCB::where('id', $intervencion->legajo_programa_social_cb_id)->with(
                'profesional',
                'programa_social',
                'estado',
                'intervenciones',
                'intervenciones.profesional'
            )->get();
            return response()->json(['message' => 'Se registrado correctamente la intervencion.', 'programas' => $programas], 200);
        } catch (\Throwable $th) {
            dd($th);
            return response()->json(['message' => 'Se ha producido un error al momento de almacenar la inscripcion. Verifique los datos ingresados.'], 500);
        }
    }

    // Store Actividad
    public function store_actividad(Request $request)
    {
        try {
            $estado = EstadoActividadCB::where('description', 'Activo')->first();
            $legajo = LegajoCB::where('id', $request->legajo_id)->first();

            if (!$legajo->actividades()->where('actividad_id', $request->actividad_id)->exists()) {
                $legajo->actividades()->attach($request->actividad_id, [
                    'fecha_inscripcion' => $request->fecha_inscripcion,
                    'estado_id' => $estado->id
                ]);
            } else {
                return response()->json(['message' => 'La Actividad ya ha sido agrego previamente. Verifique los datos ingresados.'], 203);
            }
            $actividades = $legajo = LegajoCB::where('id', $request->legajo_id)->with('actividades')->get();
            return response()->json(['message' => 'Se registrado correctamente la Actividad.', 'actividades' => $actividades], 200);
        } catch (\Throwable $th) {
            return response()->json(['message' => 'Se ha producido un error al momento de almacenar la inscripcion CBJ. Verifique los datos ingresados.'], 203);
        }
    }

    // Store Informe
    public function store_informe(Request $request)
    {
        try {
            $estado = EstadoInformeCB::where('description', 'Activo')->first();
            $legajo = LegajoCB::where('id', $request->legajo_id)->first();

            $informe = InformeCB::Create(
                [
                    'description' => $request->description,
                    'fecha_informe' => $request->fecha_informe,
                    'profesional_id' => Auth::user()->id,
                    'legajo_id' => $legajo->id,
                    'estado_id' => $estado->id,
                    'area_id' => $request->area_id
                ]
            );
            $informes = $legajo = LegajoCB::where('id', $request->legajo_id)->with('informes', 'informes.profesional', 'informes.estado', 'informes.area')->get();
            return response()->json(['message' => 'Se registrado correctamente el informe.', 'informes' => $informes], 200);
        } catch (\Throwable $th) {
            return response()->json(['message' => 'Se ha producido un error al momento de almacenar el informe CBJ. Verifique los datos ingresados.'], 203);
        }
    }

    public function update_informe(Request $request)
    {
        try {

            InformeCB::where('id', $request->id)->update(
                [
                    'description' => $request->description,
                    'fecha_informe' => $request->fecha_informe,
                    'area_id' => $request->area_id
                ]
            );

            $informes = $legajo = LegajoCB::where('id', $request->legajo_id)->with('informes', 'informes.profesional', 'informes.estado', 'informes.area')->get();
            return response()->json(['message' => 'Se ha actualizado correctamente el informe.', 'informes' => $informes], 200);
        } catch (\Throwable $th) {
            return response()->json(['message' => 'Se ha producido un error al momento de actualizar el informe CBJ. Verifique los datos ingresados.'], 203);
        }
    }

    public function delete_informe($id)
    {
        // Buscar el recurso por ID y eliminarlo
        $informe = InformeCB::findOrFail($id);
        $legajo_id = $informe['legajo_id'];
        $informe->delete();

        $informes = $legajo = LegajoCB::where('id', $legajo_id)->with('informes', 'informes.profesional', 'informes.estado', 'informes.area')->get();
        return response()->json(['message' => 'Se ha eliminado correctamente el informe.', 'informes' => $informes], 200);
        // Redireccionar o devolver una respuesta JSON
    }

    public function list()
    {
        $length = request('length');

        $result = LegajoCB::query();

        if (request('name')) {
            $name = json_decode(request('name'));
            $result->whereIn('id', function ($sub) use ($name) {
                $sub->selectRaw('legajos_cb.id')
                    ->from('legajos_cb')
                    ->join('person', 'person.id', '=', 'legajos_cb.person_id')
                    ->where('person.name', 'LIKE', '%' . $name . '%')
                    ->orWhere('person.lastname', 'LIKE', '%' . $name . '%');
            });
        }

        if (request('num_documento')) {
            $num_documento = json_decode(request('num_documento'));
            $result->whereIn('id', function ($sub) use ($num_documento) {
                $sub->selectRaw('legajos_cb.id')
                    ->from('legajos_cb')
                    ->join('person', 'person.id', '=', 'legajos_cb.person_id')
                    ->where('person.num_documento', 'LIKE', '%' . $num_documento . '%');
            });
        }

        if (request('date')) {
            $date = json_decode(request('date'));

            $from = date('Y-m-d', strtotime($date[0]));
            $to = date('Y-m-d', strtotime("+1 day", strtotime($date[1])));
            $result->where('fecha_inscripcion', '>=', $from)
                ->where('fecha_inscripcion', '<', $to);
        }

        if (request('estado_id')) {
            $estado_id = json_decode(request('estado_id'));
            $result->where('estado_id', $estado_id);
        }

        if (request('tipo_legajo_id')) {
            $tipo_legajo_id = json_decode(request('tipo_legajo_id'));
            $result->where('tipo_legajo_id', $tipo_legajo_id);
        }

        return  $result->with('person', 'sede', 'estadocbj', 'tipo_legajo')
            ->orderBy("legajos_cb.id", 'DESC')
            ->paginate($length)
            ->withQueryString();
    }

    public function store_archivo(Request $request)
    {
        try {
            if ($request->hasFile('file')) {

                $fileController = new FileController;
                $data = [];

                $data['file'] = $request->file('file');
                $data['legajo_id'] =  $request['legajo_id'];
                $data['area_id'] =  $request['area_id'];
                $data['description'] =  $request['description'];

                $fileController->uploadFileLegajo($data);
            } else {
                return response()->json(['message' => 'Se se ha detectado el archivo.'], 203);
            }
            $archivos = LegajoCB::where('id', $request->legajo_id)->with('archivos', 'archivos.area')->get();
            return response()->json(['message' => 'Se registrado correctamente el archivo.', 'archivos' => $archivos], 200);
        } catch (\Throwable $th) {
            dd($th);
            return response()->json(['message' => 'Se ha producido un error al momento de almacenar el Archivo. Verifique los datos ingresados.'], 203);
        }
    }

    public function delete_archivo($id){

        try {
            $file = ArchivoLegajo::where('id', $id)->first();
            $legajo_id = $file['legajo_id'];
            if (Storage::disk('legajo_cb')->exists($file->name)) {
                ArchivoLegajo::where('id', $id)->delete();
                Storage::disk('legajo_cb')->delete($file->name);
                $archivos = LegajoCB::where('id', $legajo_id)->with('archivos', 'archivos.area')->get();
                return response()->json(['message' => 'Se ha eliminado correctamente el archivo.', 'archivos' => $archivos], 200);
            } else {
                return response()->json(['message' => 'Se ha encontrado el archivo que desea eliminar. Comuniquese con el administrador.'], 203);
            }
        } catch (\Throwable $th) {
            return response()->json(['message' => 'Se ha producido un error al momento de intentar eliminar el archivo. Comuniquese con el administrador.'], 203);
        }
    }

    public function update_legajo(Request $request)
    {
        try {
            //code...
            LegajoCB::where('id', $request->id)->update(
                [
                    'sede_id' => $request->sede_id,
                    'estado_id' => $request->estado_id,
                    'canal_atencion_id' => $request->canal_atencion_id,
                    'fecha_inscripcion' => $request->fecha_inscripcion,
                    'fecha_inicio' => $request->fecha_inicio,
                    'observacion' => $request->observacion
                ]
            );
            return response()->json(['message' => 'Se ha actualizado correctamente el legajo.'], 200);
        } catch (\Throwable $th) {
            dd($th);
            return response()->json(['message' => 'Se ha producido un error al momento de intentar eliminar el archivo. Comuniquese con el administrador.'], 203);
        }
    }
}
