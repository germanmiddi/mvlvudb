<?php

namespace App\Http\Controllers\Manager\Masterdata;

use App\Exports\MasterDataExport;
use App\Models\Manager\CentroSalud;
use App\Models\Manager\EducationData;
use App\Models\Manager\EscuelaDependencia;
use App\Models\Manager\EscuelaV2;
use App\Models\Manager\Localidad;
use App\Models\Manager\NivelEducativo;
use App\Models\Manager\ProgramaSocial;
use App\Models\Manager\SocialData;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Redirect;
use App\Http\Controllers\Controller;
use App\Models\Manager\ActividadCB;
use App\Models\Manager\AreaLegajoCB;
use App\Models\Manager\Escuela;
use App\Models\Manager\ProgramaSocialCB;
use Carbon\Carbon;
use App\Models\Manager\TipoTramite;
use Maatwebsite\Excel\Facades\Excel;

class MasterdataController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        return Inertia::render('Manager/Masterdata/Index');

    }


    public function get_tipo_tramite($dependencia_id)
    {

        $tipo_tramite = TipoTramite::where('dependencia_id', $dependencia_id)->get();
        return response()->json($tipo_tramite);

    }

    public function store_tipo_tramite(Request $request)
    {

        $description = $request->input('description');
        $dependencia_id = $request->input('dependencia_id');

        if (!$description || !$dependencia_id) {
            return response()->json(['message' => 'El campo descripción es requerido'], 422);
        }

        $item = TipoTramite::create([
            'description' => $description,
            'dependencia_id' => $dependencia_id,
            'activo' => 1,
            'created_at' => Carbon::now()
        ]);

        return response()->json(['message' => 'Datos guardados correctamente'], 200);

    }

    public function update_tipo_tramite(Request $request)
    {

        $itemId = $request->input('id'); // Obtener el id del item desde la solicitud
        $itemDescription = $request->input('description'); // Obtener los datos del item desde la solicitud
        $activo = $request->input('activo'); // Obtener los datos del item desde la solicitud

        // Buscar el registro TipoTramite por su id
        $tipoTramite = TipoTramite::find($itemId);

        if (!$tipoTramite) {
            return response()->json(['message' => 'Registro no encontrado'], 404);
        }

        // Actualizar los campos del registro con los nuevos datos
        $tipoTramite->update([
            'description' => $itemDescription,
            'activo' => $activo,
            'updated_at' => Carbon::now()
        ]);

        return response()->json(['message' => 'Datos actualizados correctamente'], 200);
    }

    public function hideTipoTramite(Request $request)
    {

        $tipoTramite = TipoTramite::find($request->id);

        if (!$tipoTramite) {
            return response()->json(['message' => 'Registro no encontrado'], 404);
        }

        $tipoTramite->activo = $tipoTramite->activo == 1 ? 0 : 1;
        // dd($tipoTramite->activo);
        $tipoTramite->save();

        return response()->json(['message' => 'Datos actualizados correctamente'], 200);

    }

    public function destroyTipoTramite(Request $request)
    {

        $tipoTramite = TipoTramite::find($request->id);

        if (!$tipoTramite) {
            return response()->json(['message' => 'Registro no encontrado'], 404);
        }
        $tramitesAsociados = $tipoTramite->tramites()->count();
        if ($tramitesAsociados > 0) {
            return response()->json(['message' => 'No se puede eliminar este TipoTramite porque está siendo utilizado en trámites'], 422);
        }
        $tipoTramite->delete();

        return response()->json(['message' => 'Datos eliminados correctamente'], 200);
    }

    // public function update_tipo_tramite(Request $request){
    //     $item = $request->input('item');
    //     dd($item);
    //     // Ahora puedes acceder a los campos del item, por ejemplo:
    //     // $description = $item->description;
    //     // dd($description);

    //     // $item->update([
    //     //     'description' => $item['description'],
    //     //     'updated_at' => Carbon::now()
    //     // ]);

    //     return response()->json(['message' => 'Datos actualizados correctamente'], 200);


    // }

    /**
     * ESCUELAS
     */

    public function get_escuela($dependencia_id)
    {

        $escuelas = Escuela::where('dependencia_id', $dependencia_id)->get();
        return response()->json($escuelas);

    }

    public function store_escuela(Request $request)
    {

        $description = $request->input('description');
        $dependencia_id = $request->input('dependencia_id');

        if (!$description || !$dependencia_id) {
            return response()->json(['message' => 'El campo descripción es requerido'], 422);
        }

        $item = Escuela::create([
            'description' => $description,
            'dependencia_id' => $dependencia_id,
            'infante' => $request->input('infante') == 'true' ? 1 : 0,
            'primaria' => $request->input('primaria') == 'true' ? 1 : 0,
            'secundaria' => $request->input('secundaria') == 'true' ? 1 : 0,
            'nocturna' => $request->input('nocturna') == 'true' ? 1 : 0,
            'activo' => 1
        ]);

        return response()->json(['message' => 'Datos guardados correctamente'], 200);

    }

    public function update_escuela(Request $request)
    {

        $itemId = $request->input('id'); // Obtener el id del item desde la solicitud
        $itemDescription = $request->input('description'); // Obtener los datos del item desde la solicitud
        $activo = $request->input('activo'); // Obtener los datos del item desde la solicitud

        // Buscar el registro TipoTramite por su id
        $escuela = Escuela::find($itemId);

        if (!$escuela) {
            return response()->json(['message' => 'Registro no encontrado'], 404);
        }

        // Actualizar los campos del registro con los nuevos datos
        $escuela->update([
            'description' => $itemDescription,
            'activo' => $activo,
            'infante' => $request->input('infante') == 'true' ? 1 : 0,
            'primaria' => $request->input('primaria') == 'true' ? 1 : 0,
            'secundaria' => $request->input('secundaria') == 'true' ? 1 : 0,
            'nocturna' => $request->input('nocturna') == 'true' ? 1 : 0,
            'updated_at' => Carbon::now()
        ]);

        return response()->json(['message' => 'Datos actualizados correctamente'], 200);
    }

    public function hide_escuela(Request $request)
    {

        $escuela = Escuela::find($request->id);

        if (!$escuela) {
            return response()->json(['message' => 'Registro no encontrado'], 404);
        }

        $escuela->activo = $escuela->activo == 1 ? 0 : 1;
        // dd($tipoTramite->activo);
        $escuela->save();

        return response()->json(['message' => 'Datos actualizados correctamente'], 200);

    }

    public function export_datos(Request $request)
    {
        return Excel::download(new MasterDataExport(), 'masteData.xlsx');
    }

    /// Programas Sociales - Centros Barriales..

    public function get_programas_sociales_cb()
    {

        $programas_sociales = ProgramaSocialCB::get();
        return response()->json($programas_sociales);

    }

    public function store_programa_social_cb(Request $request)
    {

        $description = $request->input('description');

        $item = ProgramaSocialCB::create([
            'description' => $description,
            'activo' => 1,
            'created_at' => Carbon::now()
        ]);

        return response()->json(['message' => 'Datos guardados correctamente'], 200);

    }

    public function update_programa_social_cb(Request $request)
    {

        $itemId = $request->input('id'); // Obtener el id del item desde la solicitud
        $itemDescription = $request->input('description'); // Obtener los datos del item desde la solicitud
        $activo = $request->input('activo'); // Obtener los datos del item desde la solicitud

        // Buscar el registro TipoTramite por su id
        $programaSocial = ProgramaSocialCB::find($itemId);

        if (!$programaSocial) {
            return response()->json(['message' => 'Registro no encontrado'], 404);
        }

        // Actualizar los campos del registro con los nuevos datos
        $programaSocial->update([
            'description' => $itemDescription,
            'activo' => $activo,
            'updated_at' => Carbon::now()
        ]);

        return response()->json(['message' => 'Datos actualizados correctamente'], 200);
    }

    public function hideProgramaSocialCB(Request $request)
    {

        $programaSocial = ProgramaSocialCB::find($request->id);

        if (!$programaSocial) {
            return response()->json(['message' => 'Registro no encontrado'], 404);
        }

        $programaSocial->activo = $programaSocial->activo == 1 ? 0 : 1;
        // dd($tipoTramite->activo);
        $programaSocial->save();

        return response()->json(['message' => 'Datos actualizados correctamente'], 200);

    }

    public function destroyProgramaSocialCB(Request $request)
    {

        $programaSocial = ProgramaSocialCB::find($request->id);

        if (!$programaSocial) {
            return response()->json(['message' => 'Registro no encontrado'], 404);
        }
        /* $tramitesAsociados = $programaSocial->tramites()->count();
        if ($tramitesAsociados > 0) {
            return response()->json(['message' => 'No se puede eliminar este TipoTramite porque está siendo utilizado en trámites'], 422);
        } */
        // TODO: Verificar la existencia legajos antes de Eliminar.
        $programaSocial->delete();

        return response()->json(['message' => 'Datos eliminados correctamente'], 200);
    }

    /// Actividades - Centros Barriales..

    public function get_actividades_cb()
    {

        $actividades = ActividadCB::get();
        return response()->json($actividades);

    }

    public function store_actividad_cb(Request $request)
    {

        $description = $request->input('description');

        $item = ActividadCB::create([
            'description' => $description,
            'activo' => 1,
            'created_at' => Carbon::now()
        ]);

        return response()->json(['message' => 'Datos guardados correctamente'], 200);

    }

    public function update_actividad_cb(Request $request)
    {

        $itemId = $request->input('id'); // Obtener el id del item desde la solicitud
        $itemDescription = $request->input('description'); // Obtener los datos del item desde la solicitud
        $activo = $request->input('activo'); // Obtener los datos del item desde la solicitud

        // Buscar el registro TipoTramite por su id
        $actividad = ActividadCB::find($itemId);

        if (!$actividad) {
            return response()->json(['message' => 'Registro no encontrado'], 404);
        }

        // Actualizar los campos del registro con los nuevos datos
        $actividad->update([
            'description' => $itemDescription,
            'activo' => $activo,
            'updated_at' => Carbon::now()
        ]);

        return response()->json(['message' => 'Datos actualizados correctamente'], 200);
    }

    public function hideActividadCB(Request $request)
    {

        $actividad = ActividadCB::find($request->id);

        if (!$actividad) {
            return response()->json(['message' => 'Registro no encontrado'], 404);
        }

        $actividad->activo = $actividad->activo == 1 ? 0 : 1;
        // dd($tipoTramite->activo);
        $actividad->save();

        return response()->json(['message' => 'Datos actualizados correctamente'], 200);

    }

    public function destroyActividadCB(Request $request)
    {

        $actividad = ActividadCB::find($request->id);

        if (!$actividad) {
            return response()->json(['message' => 'Registro no encontrado'], 404);
        }
        /* $tramitesAsociados = $programaSocial->tramites()->count();
        if ($tramitesAsociados > 0) {
            return response()->json(['message' => 'No se puede eliminar este TipoTramite porque está siendo utilizado en trámites'], 422);
        } */
        // TODO: Verificar la existencia legajos antes de Eliminar.
        $actividad->delete();

        return response()->json(['message' => 'Datos eliminados correctamente'], 200);
    }

    /// Areas - Legajo

    public function get_areas_legajo_cb()
    {

        $areas = AreaLegajoCB::get();
        return response()->json($areas);

    }

    public function store_areas_legajo_cb(Request $request)
    {

        $description = $request->input('description');

        $item = AreaLegajoCB::create([
            'description' => $description,
            'activo' => 1,
            'created_at' => Carbon::now()
        ]);

        return response()->json(['message' => 'Datos guardados correctamente'], 200);

    }

    public function update_areas_legajo_cb(Request $request)
    {

        $itemId = $request->input('id'); // Obtener el id del item desde la solicitud
        $itemDescription = $request->input('description'); // Obtener los datos del item desde la solicitud
        $activo = $request->input('activo'); // Obtener los datos del item desde la solicitud

        // Buscar el registro TipoTramite por su id
        $area = AreaLegajoCB::find($itemId);

        if (!$area) {
            return response()->json(['message' => 'Registro no encontrado'], 404);
        }

        // Actualizar los campos del registro con los nuevos datos
        $area->update([
            'description' => $itemDescription,
            'activo' => $activo,
            'updated_at' => Carbon::now()
        ]);

        return response()->json(['message' => 'Datos actualizados correctamente'], 200);
    }

    public function hideAreaLegajoCB(Request $request)
    {

        $area = AreaLegajoCB::find($request->id);

        if (!$area) {
            return response()->json(['message' => 'Registro no encontrado'], 404);
        }

        $area->activo = $area->activo == 1 ? 0 : 1;
        // dd($tipoTramite->activo);
        $area->save();

        return response()->json(['message' => 'Datos actualizados correctamente'], 200);

    }

    public function destroyAreaLegajoCB(Request $request)
    {

        $area = AreaLegajoCB::find($request->id);

        if (!$area) {
            return response()->json(['message' => 'Registro no encontrado'], 404);
        }
        /* $tramitesAsociados = $programaSocial->tramites()->count();
        if ($tramitesAsociados > 0) {
            return response()->json(['message' => 'No se puede eliminar este TipoTramite porque está siendo utilizado en trámites'], 422);
        } */
        // TODO: Verificar la existencia legajos antes de Eliminar.
        $area->delete();

        return response()->json(['message' => 'Datos eliminados correctamente'], 200);
    }

    public function get_centroSalud()
    {
        $centros = CentroSalud::get();
        return response()->json($centros);
    }
    public function store_centroSalud(Request $request)
    {
        $description = $request->input('description');

        $item = CentroSalud::create([
            'description' => $description,
            'activo' => 1,
            'created_at' => Carbon::now()
        ]);

        return response()->json(['message' => 'Datos guardados correctamente'], 200);
    }
    public function update_centroSalud(Request $request)
    {
        $itemId = $request->input('id'); // Obtener el id del item desde la solicitud
        $itemDescription = $request->input('description'); // Obtener los datos del item desde la solicitud
        $activo = $request->input('activo'); // Obtener los datos del item desde la solicitud

        // Buscar el registro TipoTramite por su id
        $centro = CentroSalud::find($itemId);

        if (!$centro) {
            return response()->json(['message' => 'Registro no encontrado'], 404);
        }

        // Actualizar los campos del registro con los nuevos datos
        $centro->update([
            'description' => $itemDescription,
            'activo' => $activo,
            'updated_at' => Carbon::now()
        ]);

        return response()->json(['message' => 'Datos actualizados correctamente'], 200);
    }
    public function hide_centroSalud(Request $request)
    {
        $centro = CentroSalud::find($request->id);

        if (!$centro) {
            return response()->json(['message' => 'Registro no encontrado'], 404);
        }

        $centro->activo = $centro->activo == 1 ? 0 : 1;
        $centro->save();

        return response()->json(['message' => 'Datos actualizados correctamente'], 200);
    }

    public function get_programaSocial()
    {
        $programasSociales = ProgramaSocial::get();
        return response()->json($programasSociales);
    }

    public function store_programaSocial(Request $request)
    {
        $description = $request->input('description');

        $item = ProgramaSocial::create([
            'description' => $description,
            'activo' => 1,
            'created_at' => Carbon::now()
        ]);

        return response()->json(['message' => 'Datos guardados correctamente'], 200);
    }

    public function update_programaSocial(Request $request)
    {
        $itemId = $request->input('id');
        $itemDescription = $request->input('description');
        $activo = $request->input('activo');

        // Buscar el registro TipoTramite por su id
        $programaSocial = ProgramaSocial::find($itemId);

        if (!$programaSocial) {
            return response()->json(['message' => 'Registro no encontrado'], 404);
        }

        // Actualizar los campos
        $programaSocial->update([
            'description' => $itemDescription,
            'activo' => $activo,
            'updated_at' => Carbon::now()
        ]);

        return response()->json(['message' => 'Datos actualizados correctamente'], 200);
    }

    public function hide_programaSocial(Request $request)
    {
        $programaSocial = ProgramaSocial::find($request->id);

        if (!$programaSocial) {
            return response()->json(['message' => 'Registro no encontrado'], 404);
        }

        $programaSocial->activo = $programaSocial->activo == 1 ? 0 : 1;
        $programaSocial->save();

        return response()->json(['message' => 'Datos actualizados correctamente'], 200);
    }

    public function destroy_programaSocial(Request $request)
    {
        $programaSocial = ProgramaSocial::find($request->id);

        if (!$programaSocial) {
            return response()->json(['message' => 'Registro no encontrado'], 404);
        }

        $tramitesAsociados = SocialData::where('programa_social_id', $programaSocial->id)->count();
        if ($tramitesAsociados > 0) {
            return response()->json(['message' => 'El programa social no puede ser eliminado porque tiene trámites asociados.'], 422);
        }
        //Verificar la existencia legajos antes de Eliminar.
        $programaSocial->delete();

        return response()->json(['message' => 'Datos eliminados correctamente'], 200);
    }
    public function get_escuelasv2()
    {
        $escuelas = EscuelaV2::with('niveles')->get();
        return response()->json($escuelas);
    }

    public function store_escuelav2(Request $request)
    {
        // Actualizar los campos
        $escuela = EscuelaV2::create([
            'numero_sigla' => $request->numero_sigla ?? null,
            'nombre_completo' => $request->nombre_completo,
            'direccion' => $request->direccion ?? null,
            'localidad_id' => $request->localidad_id ?? null,
            'telefono' => $request->telefono ?? null,
            'mail' => $request->mail ?? null,
            'dependencia_id' => $request->dependencia_id ?? null,
            'activo' => $request->activo,
            'updated_at' => Carbon::now()
        ]);

        if (!empty($request->nivelesSelected)) {
            $escuela->niveles()->sync($request->nivelesSelected);
        }

        return response()->json(['message' => 'Datos guardados correctamente'], 200);
    }

    public function update_escuelav2(Request $request)
    {
        // Buscar el registro TipoTramite por su id
        $escuela = EscuelaV2::find($request->id);
        if (!$escuela) {
            return response()->json(['message' => 'No se logró encontrar el registro'], 404);
        }

        // Actualizar los campos
        $escuela->update([
            'numero_sigla' => $request->numero_sigla ?? null,
            'nombre_completo' => $request->nombre_completo,
            'direccion' => $request->direccion ?? null,
            'localidad_id' => $request->localidad_id ?? null,
            'telefono' => $request->telefono ?? null,
            'mail' => $request->mail ?? null,
            'dependencia_id' => $request->dependencia_id ?? null,
            'activo' => $request->activo ?? null,
            'updated_at' => Carbon::now()
        ]);

        if (!empty($request->nivelesSelected)) {
            $escuela->niveles()->sync($request->nivelesSelected);
        }

        return response()->json(['message' => 'Datos actualizados correctamente'], 200);
    }

    public function hide_escuelav2(Request $request)
    {
        $escuela = EscuelaV2::find($request->id);

        if (!$escuela) {
            return response()->json(['message' => 'Registro no encontrado'], 404);
        }

        $escuela->activo = $escuela->activo == 1 ? 0 : 1;
        $escuela->save();

        return response()->json(['message' => 'Datos actualizados correctamente'], 200);
    }

    public function destroy_escuelav2(Request $request)
    {
        $escuela = EscuelaV2::find($request->id);

        if (!$escuela) {
            return response()->json(['message' => 'Registro no encontrado'], 404);
        }
        $tramitesAsociados = EducationData::where('escuela_id', $escuela->id)->count();
        if ($tramitesAsociados > 0) {
            return response()->json(['message' => 'La escuela no puede ser eliminada porque tiene trámites asociados.'], 422);
        }

        $escuela->delete();

        return response()->json(['message' => 'Datos eliminados correctamente'], 200);
    }

    public function get_escuelasData()
    {
        $localidades = Localidad::all();
        $dependencia = EscuelaDependencia::all();
        $nivelesEducativos = NivelEducativo::all();

        $data = [
            'localidades' => $localidades,
            'dependencias' => $dependencia,
            'nivelesEducativos' => $nivelesEducativos
        ];

        return response()->json($data);
    }
}
