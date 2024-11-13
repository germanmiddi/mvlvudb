<?php

namespace App\Http\Controllers\Manager\CentrosBarriales;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Manager\Uploads\FileController;
use App\Models\Manager\ActividadCB;
use App\Models\Manager\ActividadCBLegajo;
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
use App\Models\Manager\AddressData;
use App\Models\Manager\AditionalData;
use App\Models\Manager\AutorizacionCb;
use App\Models\Manager\ContactData;
use App\Models\Manager\EducationData;
use App\Models\Manager\EstadoEducativo;
use App\Models\Manager\LegajoPedagogia;
use App\Models\Manager\Localidad;
use App\Models\Manager\LegajoProgramaSocialCB;
use App\Models\Manager\NivelEducativo;
use App\Models\Manager\Pais;
use App\Models\Manager\CentroSalud;
use App\Models\Manager\Cud;
use App\Models\Manager\EmprendedorCB;
use App\Models\Manager\Escuela;
use App\Models\Manager\EscuelaDependencia;
use App\Models\Manager\EscuelaNivel;
use App\Models\Manager\EscuelaTurno;
use App\Models\Manager\EstadoGabineteCB;
use App\Models\Manager\EstadoPedagogia;
use App\Models\Manager\GabineteCB;
use App\Models\Manager\Parentesco;
use App\Models\Manager\Person;
use App\Models\Manager\ProgramaSocialCB;
use App\Models\Manager\SaludData;
use App\Models\Manager\Sede;
use App\Models\Manager\SituacionConyugal;
use App\Models\Manager\SocialData;
use App\Models\User;
use App\Models\Manager\TipoLegajoCb;
use App\Models\Manager\TipoOcupacion;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Carbon\Carbon;
use Svg\Tag\Rect;

class LegajosCBController extends Controller
{
    protected $FamiliarConviviente = ['Madre', 'Padre', 'Abuela/o', 'Adulto/a Responsable', 'Hermana/o Mayor de Edad', 'Tia/o', 'Madrastra/Padrastro', 'Pareja Conviviente', 'Hija/o Hijastro/a', 'Hermana/o Menor de Edad', 'Otro Familiar'];
    
    public function index(Request $request)
    {
        $sede_id = $request->query('sede');
        $legajo = $request->query('tipo_legajo');
        
        return Inertia::render(
            'Manager/CentrosBarriales/Legajos/Index',
            [
                'tiposLegajo' => TipoLegajoCb::all(),
                'estados' => EstadoCbj::all(),
                'escuelas' => Escuela::whereNull('dependencia_id')->get(),
                'sedes' => Sede::whereNotIn('id', [8, 9])->get(),
                'selectedSede' => $sede_id, 
                'selectedLegajo' => $legajo,
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
                        'person.education.escuelaPrimaria',
                        'tipo_legajo',
                        'programas_sociales',
                        'programas_sociales.profesional',
                        'programas_sociales.programa_social',
                        'programas_sociales.estado',
                        'programas_sociales.intervenciones',
                        'programas_sociales.intervenciones.profesional',
                        'actividades',
                        'actividades.actividad',
                        'actividades.estado',
                        'informes',
                        'informes.profesional',
                        'informes.estado',
                        'informes.area',
                        'archivos',
                        'archivos.area',
                        'parentesco',
                        'gabinete',
                        'gabinete.estado',
                        'emprendedor',
                        'assigned',
                        'pedagogia',
                        'pedagogia.estado',
                    )->get(),
                'users' => User::orderBy('name')->get(),
                'programasSociales' => ProgramaSocialCB::all(),
                'actividades' => ActividadCB::all(),
                'areas' => AreaLegajoCB::active()->get(),
                'localidades' => Localidad::all(),
                'sedes' => Sede::all(),
                'canalesAtencion' => CanalAtencion::all(),
                'tiposLegajo' => TipoLegajoCb::all(),
                'estados' => EstadoCbj::all(),

                'paises' => Pais::all(),
                'parentescos' => Parentesco::whereIn('description', $this->FamiliarConviviente)->get(),
                'situacionesConyugal' => SituacionConyugal::all(),
                'tiposOcupacion' => TipoOcupacion::all(),
                'estadosEducativo' => EstadoEducativo::all(),
                'nivelesEducativo' => NivelEducativo::all(),

                'centrosSalud' => CentroSalud::active()->get(),

                'escuelas' => Escuela::where('primaria', true)->whereNull('dependencia_id')->get(),
                'turnosEducativo' => EscuelaTurno::all(),
                'escuelasDependencia' => EscuelaDependencia::active()->get(),
                'escuelasNivel' => EscuelaNivel::get(),

                'estadosGabinete' => EstadoGabineteCB::all(),

                'estadosPedagogia' => EstadoPedagogia::all(),

            ]
        );
    }

    public function update_estado($id, Request $request)
    {
        try {
            LegajoCB::where('id', $id)->update(
                [
                    'estado_id' => $request->estado_id
                ]
            );
            return response()->json(['message' => 'Se ha actualizado correctamente el estado del legajo.'], 200);
        } catch (\Throwable $th) {
            return response()->json(['message' => 'Se ha producido un error al momento de intentar actualizar el estado del legajo. Comuniquese con el administrador.'], 203);
        }
    }

    public function update_estado_programa($id, Request $request)
    {
        try {
            LegajoProgramaSocialCB::where('id', $id)->update(
                [
                    'estado_id' => $request->estado_id
                ]
            );
            $programas = LegajoProgramaSocialCB::where('id', $id)->with(
                'profesional',
                'programa_social',
                'estado',
                'intervenciones',
                'intervenciones.profesional'
            )->get();
            return response()->json(['message' => 'Se ha actualizado correctamente el estado del programa.', 'programas' => $programas], 200);
        } catch (\Throwable $th) {
            dd($th);
            return response()->json(['message' => 'Se ha producido un error al momento de intentar actualizar el estado del programa. Comuniquese con el administrador.'], 203);
        }
    }

    public function update_estado_actividad($id, Request $request)
    {
        try {
            ActividadCBLegajo::where('id', $id)->update(
                [
                    'estado_id' => $request->estado_id
                ]
            );
            $legajo_id = ActividadCBLegajo::where('id', $id)->value('legajo_id');
            $actividades = $legajo = LegajoCB::where('id', $legajo_id)->with('actividades', 'actividades.actividad', 'actividades.estado')->get();
            return response()->json(['message' => 'Se actualizado correctamente el estado de la Actividad.', 'actividades' => $actividades], 200);
        } catch (\Throwable $th) {
            dd($th);
            return response()->json(['message' => 'Se ha producido un error al momento de intentar actualizar el estado de la actividad. Comuniquese con el administrador.'], 203);
        }
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
                    'fecha' => $request->fecha,
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
            return response()->json(['message' => 'Se ha producido un error al momento de almacenar la inscripcion. Verifique los datos ingresados.'], 500);
        }
    }

    // Store Actividad
    public function store_actividad(Request $request)
    {
        try {
            $estado = EstadoActividadCB::where('description', 'Activo')->first();
            $legajo = LegajoCB::where('id', $request->legajo_id)->first();

            // Control de la existencia del programa social asociado al legajo.
            if (!ActividadCBLegajo::where('actividad_id', $request->actividad_id)->where('legajo_id', $request->legajo_id)->where('estado_id', $estado->id)->exists()) {
                ActividadCBLegajo::Create(
                    [
                        'legajo_id' => $request->legajo_id,
                        'actividad_id' => $request->actividad_id,
                        'fecha_inscripcion' => $request->fecha_inscripcion,
                        'estado_id' => $estado->id
                    ]
                );
            } else {
                return response()->json(['message' => 'La Actividad ya ha sido agrego previamente. Verifique los datos ingresados.'], 203);
            }

            $actividades = $legajo = LegajoCB::where('id', $request->legajo_id)->with('actividades', 'actividades.actividad', 'actividades.estado')->get();
            return response()->json(['message' => 'Se registrado correctamente la Actividad.', 'actividades' => $actividades], 200);
        } catch (\Throwable $th) {
            dd($th);
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

        if (request('num_documento_nino')) {
            $num_documento_nino = json_decode(request('num_documento_nino'));
            $result->whereIn('id', function ($sub) use ($num_documento_nino) {
                $sub->selectRaw('legajos_cb.id')
                    ->from('legajos_cb')
                    ->join('person', 'person.id', '=', 'legajos_cb.person_id')
                    ->where('person.num_documento', 'LIKE', '%' . $num_documento_nino . '%');
            });
        }
        
        if (request('num_documento_adulto')) {
            $num_documento_adulto = json_decode(request('num_documento_adulto'));
            $result->whereIn('id', function ($sub) use ($num_documento_adulto) {
                $sub->selectRaw('legajos_cb.id')
                    ->from('legajos_cb')
                    ->join('person', 'person.id', '=', 'legajos_cb.responsable_id')
                    ->where('person.num_documento', 'LIKE', '%' . $num_documento_adulto . '%');
            });
        }

        if (request('escuela_id')) {
            $escuela_id = json_decode(request('escuela_id'));
            $result->whereIn('id', function ($sub) use ($escuela_id) {
                $sub->selectRaw('legajos_cb.id')
                    ->from('legajos_cb')
                    ->join('person','person.id','=', 'legajos_cb.person_id')
                    ->join('education_data','education_data.person_id','=', 'person.id')
                    ->where(function ($query) use ($escuela_id){
                        $query->where('education_data.escuela_primaria_id', $escuela_id)
                            ->orWhere('education_data.escuela_secundaria_id', $escuela_id)
                            ->orWhere('education_data.escuela_nocturna_id', $escuela_id)
                            ->orWhere('education_data.escuela_infante_id', $escuela_id)
                            ->orWhere('education_data.escuela_id', $escuela_id);
                    });
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

        if (request('sede_id')) {
            $sede_id = json_decode(request('sede_id'));
            $result->where('sede_id', $sede_id);
        }
        
        if (request('min_years') && request('max_years')) {
            $min_years = (int) trim(request('min_years'), '"');
            $max_years = (int) trim(request('max_years'), '"');
            
            if($max_years > 0 && $max_years > $min_years){
                $dates = $this->getDatesByYearsOld($min_years, $max_years);
                $result->whereIn('id', function ($sub) use ($dates) {
                    $sub->selectRaw('legajos_cb.id')
                        ->from('legajos_cb')
                        ->join('person', 'person.id', '=', 'legajos_cb.person_id')
                        ->whereBetween('person.fecha_nac', $dates);
                });
            }
        }

        return  $result->with('person', 'sede', 'estadocbj', 'tipo_legajo')
            ->orderBy("legajos_cb.id", 'DESC')
            ->paginate($length)
            ->withQueryString();
    }

    public function getDatesByYearsOld($min_years, $max_years)
    {
        $today = Carbon::today();

            //Se busca personas que nacieron despues de $min_birthdate
            $min_birthdate = $today->copy()->subYears($max_years + 1)->startOfDay(); 

            //Se busca personas que nacieron despues de $max_birthdate
            $max_birthdate = $today->copy()->subYears($min_years)->endOfDay();

        return [$min_birthdate, $max_birthdate];
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

    public function delete_programa_intervencion($id){

        try {
           // Buscar el recurso por ID y eliminarlo
            $intervencion = IntervencionProgramaSocialCB::findOrFail($id);
            $intervencion->activo = false;
            $intervencion->save();

            $programas = LegajoProgramaSocialCB::where('id', $intervencion->legajo_programa_social_cb_id)->with(
                'profesional',
                'programa_social',
                'estado',
                'intervenciones',
                'intervenciones.profesional'
            )->get();
            return response()->json(['message' => 'Se ha eliminado correctamente la intervenciones.', 'programas' => $programas], 200);
            // Redireccionar o devolver una respuesta JSON

        } catch (\Throwable $th) {
            return response()->json(['message' => 'Se ha producido un error al momento de intentar eliminar la intervencion. Comuniquese con el administrador.'], 203);
        }
    }

    public function update_programa_intervencion(Request $request){

        try {
           // Buscar el recurso por ID y eliminarlo
            $intervencion = IntervencionProgramaSocialCB::findOrFail($request->id);
            $intervencion->fecha = $request->fecha;
            $intervencion->description = $request->description;
            $intervencion->profesional_id = $request->profesional_id;
            $intervencion->save();

            $programas = LegajoProgramaSocialCB::where('id', $intervencion->legajo_programa_social_cb_id)->with(
                'profesional',
                'programa_social',
                'estado',
                'intervenciones',
                'intervenciones.profesional'
            )->get();
            return response()->json(['message' => 'Se ha actualizado correctamente la intervenciones.', 'programas' => $programas], 200);
            // Redireccionar o devolver una respuesta JSON

        } catch (\Throwable $th) {
            return response()->json(['message' => 'Se ha producido un error al momento de intentar actualizar la intervencion. Comuniquese con el administrador.'], 203);
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
                    'semaforo_id' => $request->semaforo_id,
                    'observacion' => $request->observacion
                ]
            );
            return response()->json(['message' => 'Se ha actualizado correctamente el legajo.'], 200);
        } catch (\Throwable $th) {
            return response()->json(['message' => 'Se ha producido un error al momento de intentar eliminar el archivo. Comuniquese con el administrador.'], 203);
        }
    }

    public function update_legajoDireccion(Request $request)
    {
        try {
            //code...
            $person_id =  LegajoCB::where('id', $request->id)->value('person_id');

            AddressData::where('person_id', $person_id)->update(
                [
                    'calle' => $request->calle,
                    'piso' => $request->piso,
                    'dpto' => $request->dpto,
                    'number' => $request->number,
                    'localidad_id' => $request->localidad_id,
                    'observacion' => $request->observacion
                ]
            );
            return response()->json(['message' => 'Se ha actualizado correctamente la dirección del legajo.'], 200);
        } catch (\Throwable $th) {
            return response()->json(['message' => 'Se ha producido un error al momento de intentar actualizar los datos de la dirección del legajo. Comuniquese con el administrador.'], 203);
        }
    }

    public function update_legajoResponsable(Request $request)
    {
        try {
            $person_id = LegajoCB::where('id', $request->id)->value('responsable_id');

            LegajoCB::where('id', $request->id)->update(
                [
                    'parentesco_id' => $request->parentesco_id,
                    'phone_emergency' => $request->phone_emergency
                ]
            );

            Person::where('id',$person_id)->update(
                [
                    'lastname' => $request->lastname ?? null,
                    'name' => $request->name ?? null,
                    'fecha_nac' => $request->fecha_nac ?? null,
                ]
            );

            ContactData::where('person_id',$person_id)->update(
                [
                    'phone' => $request->phone ?? null,
                    'celular' => $request->celular ?? null
                ]
            );

            AddressData::where('person_id',$person_id)->update(
                [
                    'pais_id' => $request->pais_id ?? null
                ]
            );

            EducationData::where('person_id',$person_id)->update(
                [
                    'nivel_educativo_id' => $request->nivel_educativo_id ?? null,
                    'estado_educativo_id' => $request->estado_educativo_id ?? null
                ]
            );

            AditionalData::where('person_id',$person_id)->update(
                [
                    'situacion_conyugal_id' => $request->situacion_conyugal_id ?? null
                ]
            );

            SocialData::where('person_id',$person_id)->update(
                [
                    'tipo_ocupacion_id' => $request->tipo_ocupacion_id ?? null
                ]
            );
            return response()->json(['message' => 'Se ha actualizado correctamente los datos del adulto responsable del legajo.'], 200);
        } catch (\Throwable $th) {
            return response()->json(['message' => 'Se ha producido un error al momento de intentar actualizar los datos del adulto responsable del legajo. Comuniquese con el administrador.'], 203);
        }
    }

    public function update_legajoAutorizaciones(Request $request)
    {
        try {
            AutorizacionCb::where('legajo_id', $request->id)->update(
                [
                    'apoyo_escolar' => $request->apoyo_escolar,
                    'actividad_empleo' => $request->actividad_empleo,
                    'autorizacion_firmada' => $request->autorizacion_firmada,
                    'autorizacion_retirarse' => $request->autorizacion_retirarse,
                    'autorizacion_uso_imagen' => $request->autorizacion_uso_imagen
                ]
            );
            return response()->json(['message' => 'Se ha actualizado correctamente las autorizaciones del legajo.'], 200);
        } catch (\Throwable $th) {
            return response()->json(['message' => 'Se ha producido un error al momento de intentar actualizar los autorizaciones del legajo. Comuniquese con el administrador.'], 203);
        }
    }

    public function update_legajoSalud(Request $request)
    {
        try {
            $person_id = LegajoCB::where('id', $request->id)->value('person_id');

            SaludData::where('person_id',$person_id)->update(
                [
                    'apto_medico' => $request->apto_medico ?? null,
                    'fecha_apto_medico' => $request->fecha_apto_medico ?? null,
                    'vencimiento_apto_medico' => $request->vencimiento_apto_medico ?? null,
                    'electrocardiograma' => $request->electrocardiograma ?? null,
                    'fecha_electrocardiograma' => $request->fecha_electrocardiograma ?? null,
                    'libreta_vacunacion' => $request->libreta_vacunacion ?? null,
                    'centro_salud_id' => $request->centro_salud_id ?? null,
                    'observacion' => $request->observacion ?? null,
                ]
            );

            Cud::where('person_id',$person_id)->update(
                [
                    'posee_cud' => $request->posee_cud ?? null,
                    'presento_cud' => $request->presento_cud ?? null,
                    'vencimiento_cud' => $request->vencimiento_cud ?? null,
                ]
            );
            
            return response()->json(['message' => 'Se ha actualizado correctamente los datos de salud del legajo.'], 200);
        } catch (\Throwable $th) {
            return response()->json(['message' => 'Se ha producido un error al momento de intentar actualizar los datos de salud del legajo. Comuniquese con el administrador.'], 203);
        }
    }

    public function update_legajoEducacion(Request $request)
    {
        try {
            $person_id = LegajoCB::where('id', $request->id)->value('person_id');

            EducationData::where('person_id',$person_id)->update(
                [
                    'escuela_primaria_id' => $request->escuela_primaria_id ?? null,
                    'nivel_educativo_id' => $request->nivel_educativo_id ?? null,
                    'escuela_nivel_id' => $request->escuela_nivel_id ?? null,
                    'estado_educativo_id' => $request->estado_educativo_id ?? null,
                    'escuela_turno_id' => $request->escuela_turno_id ?? null,
                    'escuela_dependencia_id' => $request->escuela_dependencia_id ?? null,
                    'escuela_localidad_id' => $request->escuela_localidad_id ?? null,
                    'certificado_escolar' => $request->certificado_escolar ?? null,
                    'permanencia' => $request->permanencia ?? null,
                    'observacion' => $request->observacion ?? null,
                ]
            );
            
            return response()->json(['message' => 'Se ha actualizado correctamente los datos de educacion del legajo.'], 200);
        } catch (\Throwable $th) {
            dd($th);
            return response()->json(['message' => 'Se ha producido un error al momento de intentar actualizar los datos de educacion del legajo. Comuniquese con el administrador.'], 203);
        }
    }

    public function update_legajoGabinete(Request $request)
    {
        try {
            //$person_id = LegajoCB::where('id', $request->id)->value('person_id');

            GabineteCB::updateOrCreate(
                [
                    'legajo_id' => $request->id
                ],[
                    'legajo_id' => $request->id,
                    'estado_id' => $request->estado_id ?? null,
                    'observacion' => $request->observacion ?? null,
                ]
            );
            
            return response()->json(['message' => 'Se ha actualizado correctamente los datos de gabinete del legajo.'], 200);
        } catch (\Throwable $th) {
            return response()->json(['message' => 'Se ha producido un error al momento de intentar actualizar los datos de gabinete del legajo. Comuniquese con el administrador.'], 203);
        }
    }
    public function update_legajoPedagogia(Request $request)
    {
        try {
            
              LegajoPedagogia::updateOrCreate(
                [
                    'id' => $request->pedagogia_id
                ],
                [
                    'legajo_id' => $request->id,
                    'realizo_prueba' => $request->realizo_prueba ?? null,
                    'fecha_prueba' => $request->fecha_prueba ?? null,
                    'estado_id' => $request->estado_id ?? null,
                    'detalles' => $request->detalles ?? null,
                    'profesional' => $request->profesional ?? null,
                ]
            );
            
            return response()->json(['message' => 'Se ha actualizado correctamente los datos de pedagogía del legajo.'], 200);
        } catch (\Throwable $th) {
            return response()->json(['message' => 'Se ha producido un error al momento de intentar actualizar los datos de pedagogía del legajo. Comuniquese con el administrador.'], 203);
        }
    }

    public function update_legajoEmprendedor(Request $request)
    {
        try {
            EmprendedorCB::updateOrCreate(
                [
                    'legajo_id' => $request->id
                ],[
                    'legajo_id' => $request->id,
                    'participa' => $request->participa ?? null,
                    'fecha_inscripcion' => $request->fecha_inscripcion ?? null,
                    'fecha_finalizacion' => $request->fecha_finalizacion ?? null,
                ]
            );
            
            return response()->json(['message' => 'Se ha actualizado correctamente los datos de emprendedor del legajo.'], 200);
        } catch (\Throwable $th) {
            return response()->json(['message' => 'Se ha producido un error al momento de intentar actualizar los datos de emprendedor del legajo. Comuniquese con el administrador.'], 203);
        }
    }

    public function update_legajoTitular(Request $request)
    {
        try {
            $person_id = LegajoCB::where('id', $request->id)->value('person_id');

            Person::where('id',$person_id)->update(
                [
                    'lastname' => $request->lastname ?? null,
                    'name' => $request->name ?? null,
                    'fecha_nac' => $request->fecha_nac ?? null,
                    'genero' => $request->genero ?? null,
                ]
            );

            ContactData::where('person_id',$person_id)->update(
                [
                    'phone' => $request->phone ?? null
                ]
            );

            AddressData::where('person_id',$person_id)->update(
                [
                    'localidad_id' => $request->localidad_id ?? null
                ]
            );
            return response()->json(['message' => 'Se ha actualizado correctamente los datos del titular del legajo.'], 200);
        } catch (\Throwable $th) {
            return response()->json(['message' => 'Se ha producido un error al momento de intentar actualizar los datos del titular del legajo. Comuniquese con el administrador.'], 203);
        }
    }

    
    public function update_assignedResponsable(Request $request)
    {
        try {
            LegajoCB::updateOrCreate(
                [
                    'id' => $request->id
                ],[
                    'assigned_id' => $request->assigned_id,
                ]
            );
            
            return response()->json(['message' => 'Se ha actualizado correctamente los datos del responsable asignado.'], 200);
        } catch (\Throwable $th) {
            return response()->json(['message' => 'Se ha producido un error al momento de intentar actualizar los datos del responsable asignado. Comuniquese con el administrador.'], 203);
        }
    }
}
