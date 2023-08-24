<?php

namespace App\Http\Controllers\Manager\Tramites\Entidad;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Manager\Uploads\FileController;
use App\Models\Manager\AddressData;
use App\Models\Manager\AditionalData;
use App\Models\Manager\AutoridadEntidad;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Inertia\Inertia;

//Models
use App\Models\Manager\Pais;
use App\Models\Manager\Barrio;
use App\Models\Manager\Localidad;
use App\Models\Manager\CanalAtencion;
use App\Models\Manager\CargoAutoridad;
use App\Models\Manager\CoberturaMedica;
use App\Models\Manager\ContactData;
use App\Models\Manager\Cud;
use App\Models\Manager\EducationData;
use App\Models\Manager\Entidad;
use App\Models\Manager\EstadoEducativo;
use App\Models\Manager\NivelEducativo;
use App\Models\Manager\Parentesco;
use App\Models\Manager\TipoDocumento;
use App\Models\Manager\TipoOcupacion;
use App\Models\Manager\TipoPension;
use App\Models\Manager\TipoVivienda;
use App\Models\Manager\SituacionConyugal;
use App\Models\Manager\RolTramite;
use App\Models\Manager\TipoTramite;
use App\Models\Manager\ProgramaSocial;
use App\Models\Manager\Person;
use App\Models\Manager\SocialData;
use App\Models\Manager\TipoActividad;
use App\Models\Manager\TipoEntidad;
use App\Models\Manager\Tramite;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;

use Carbon\Carbon;

class EntidadController extends Controller
{
    public function index()
    {
        return Inertia::render('Manager/Tramites/Entidad/Index',
        [
            'toast' => Session::get('toast'),
            'tiposEntidad' => TipoEntidad::where('activo', true)->get()
        ]);
    }
    //create
    public function create()
    {
        return Inertia::render(
            'Manager/Tramites/Entidad/Create',
            [
                'localidades' => Localidad::all(),
                'cargos' => CargoAutoridad::where('activo', true)->get(),
                'tiposEntidad' => TipoEntidad::where('activo', true)->get(),
                'tiposActividad' => TipoActividad::where('activo', true)->get()
            ]
        );
    }
    //store
    public function store(Request $request)
    {
        $form = $request['form'];
        DB::beginTransaction();
        try {
            $entidad = Entidad::create(
                [ 
                    'num_entidad' => $form['num_entidad'],
                    'name' => $form['name'],
                    'objeto' => $form['objeto'] ?? null,
                    'address' => $form['address'] ?? null,
                    'phone' => $form['phone'] ?? null,
                    'email' => $form['email'] ?? null,
                    'solicitud_inscripcion' => $form['solicitud_inscripcion'] ?? null,
                    'personeria' => $form['personeria'] ?? null,
                    'eximision' => $form['eximision'] ?? null,
                    'observation' => $form['observation'] ?? null,
                    'fecha_inscripcion' => isset($form['fecha_inscripcion']) ? date("Y-m-d ", strtotime($form['fecha_inscripcion'])) : null,
                    'fecha_fundacion' => isset($form['fecha_fundacion']) ? date("Y-m-d ", strtotime($form['fecha_fundacion'])) : null,
                    'fecha_fin_mandato' => isset($form['fecha_fin_mandato']) ? date("Y-m-d ", strtotime($form['fecha_fin_mandato'])) : null,
                    'fecha_memoria' => isset($form['fecha_memoria']) ? date("Y-m-d ", strtotime($form['fecha_memoria'])) : null,
                    'fecha_asamblea' => isset($form['fecha_asamblea']) ? date("Y-m-d ", strtotime($form['fecha_asamblea'])) : null,
                    'tipo_entidad_id' => $form['tipo_entidad_id'] ?? null,
                    'localidad_id' => $form['localidad_id'] ?? null,
                    'tipo_actividad_id' => $form['tipo_actividad_id'] ?? null
                ]
            );


            foreach ($request['autoridades'] as $autoridad) {
                AutoridadEntidad::Create(
                    [
                        'name' => $autoridad['name'],
                        'phone' =>$autoridad['phone'],
    
                        'cargo_id' => $autoridad['cargo_id'],
                        'entidad_id' => $entidad->id
                    ]
                );
            
            }
            DB::commit();
            Log::info("Se ha almacenado una nueva entidad", ["Modulo" => "Entidad:store","Usuario" => Auth::user()->id.": ".Auth::user()->name, "ID Entidad" => $entidad->id ]);
            return response()->json(['message' => 'Se generado correctamente el tramite del usuario.', 'idTramites' => $entidad->id], 200);
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error("Se ha generado un error al momento de almacenar la entidad", ["Modulo" => "Entidad:store","Usuario" => Auth::user()->id.": ".Auth::user()->name, "Error" => $th->getMessage() ]);
            return response()->json(['message' => 'Se ha producido un error al momento de almacenar la entidad. Verifique los datos ingresados.'], 203);
        }
    }
    //show
    public function show($id)
    {
        //
    }
    //edit
    public function edit($id)
    {
        return Inertia::render(
            'Manager/Tramites/Entidad/Edit',
            [
                'localidades' => Localidad::all(),
                'cargos' => CargoAutoridad::where('activo', true)->get(),
                'tiposEntidad' => TipoEntidad::where('activo', true)->get(),
                'tiposActividad' => TipoActividad::where('activo', true)->get(),
                'entidad' => Entidad::where('id', $id)->with('autoridades', 'autoridades.cargo')->get()
            ]
        );
    }
    //update
    public function update(Request $request, $id)
    {
        $form = $request['form'];
        DB::beginTransaction();
        try {
           
            Entidad::where('id',$id)->update(
                [
                    'num_entidad' => $form['num_entidad'],
                    'name' => $form['name'],
                    'objeto' => $form['objeto'] ?? null,
                    'address' => $form['address'] ?? null,
                    'phone' => $form['phone'] ?? null,
                    'email' => $form['email'] ?? null,
                    'solicitud_inscripcion' => $form['solicitud_inscripcion'] ?? null,
                    'personeria' => $form['personeria'] ?? null,
                    'eximision' => $form['eximision'] ?? null,
                    'observation' => $form['observation'] ?? null,
                    'fecha_inscripcion' => isset($form['fecha_inscripcion']) ? date("Y-m-d ", strtotime($form['fecha_inscripcion'])) : null,
                    'fecha_fundacion' => isset($form['fecha_fundacion']) ? date("Y-m-d ", strtotime($form['fecha_fundacion'])) : null,
                    'fecha_fin_mandato' => isset($form['fecha_fin_mandato']) ? date("Y-m-d ", strtotime($form['fecha_fin_mandato'])) : null,
                    'fecha_memoria' => isset($form['fecha_memoria']) ? date("Y-m-d ", strtotime($form['fecha_memoria'])) : null,
                    'fecha_asamblea' => isset($form['fecha_asamblea']) ? date("Y-m-d ", strtotime($form['fecha_asamblea'])) : null,
                    'tipo_entidad_id' => $form['tipo_entidad_id'] ?? null,
                    'localidad_id' => $form['localidad_id'] ?? null,
                    'tipo_actividad_id' => $form['tipo_actividad_id'] ?? null
                ]
            );

            DB::commit();
            Log::info("Se ha actualizado un entidad", ["Modulo" => "Entidad:update","Usuario" => Auth::user()->id.": ".Auth::user()->name, "ID Entidad" => $form['id'] ]);
            return response()->json(['message' => 'Se actualizado correctamente el tramite del usuario.', 'idTramite' => $request['tramite_id'] ], 200);
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error("Se ha generado un error al momento de actualizar una entidad", ["Modulo" => "Entidad:update","Usuario" => Auth::user()->id.": ".Auth::user()->name, "Error" => $th->getMessage() ]);
            return response()->json(['message' => 'Se ha producido un error al momento de actualizar la entidad. Verifique los datos ingresados.'], 203);
        }
    }
    //destroy
    public function destroy($id)
    {
        //
    }
    //list
    public function list()
    {
        $length = request('length');
        
        $result = Entidad::query();


        $name = json_decode(request('name'));  
            $result->where('name', 'LIKE', '%'.$name.'%');

        $num_entidad = json_decode(request('num_entidad'));  
            $result->where('num_entidad', 'LIKE', '%'.$num_entidad.'%');

        
        if(request('tipo_entidad_id')){
            $tipo_entidad_id = json_decode(request('tipo_entidad_id'));
            $result->where('tipo_entidad_id', $tipo_entidad_id);
        }

        return  $result->orderBy("entidades.num_entidad", 'DESC')
            ->paginate($length)
            ->withQueryString()
            ->through(fn ($entidad) => [
                'entidad'   => $entidad,
                'tipo_entidad' => $entidad->tipoEntidad
            ]);
    }

    public function updateAutoridad(Request $request){
        $autoridad = AutoridadEntidad::find($request->id);
    
        if (!$autoridad) {
            Log::error("No se ha encontrado la autoridad que desea actualizar", ["Modulo" => "Entidad:updateAutoridad","Usuario" => Auth::user()->id.": ".Auth::user()->name, "Error" => "Id no encontrado ".$request->id ]);
            return response()->json(['message' => 'Se ha producido un error al momento de eliminar la autoridad.'], 203);
        }
        
        $autoridad->update([
            'name'      => $request->name,
            'phone'     => $request->phone,
            'updated_at' => Carbon::now()
        ]);
        Log::error("Se ha actualizado correctamente la autoridad", ["Modulo" => "Entidad:updateAutoridad","Usuario" => Auth::user()->id.": ".Auth::user()->name, "ID Autoridad" => $request->id ]);
        return response()->json(['message' => 'Se ha eliminado correctamente la autoridad'], 200);
    }

    public function addAutoridad(Request $request){
        DB::beginTransaction();
        try {    

            $autoridad = AutoridadEntidad::Create(
                [
                    'name' => $request['name'],
                    'phone' =>$request['phone'],

                    'cargo_id' => $request['cargo_id'],
                    'entidad_id' => $request['id_entidad'],
                ]);
            
            DB::commit();
            Log::info("Se ha almacenado una nueva autoridad", ["Modulo" => "Entidad:addAutoridad","Usuario" => Auth::user()->id.": ".Auth::user()->name, "ID Autoridad" => $autoridad->id ]);
            return response()->json(['message' => 'Se generado correctamente el tramite del usuario.', 'idAutoridad' => $autoridad->id, 'autoridad' => $autoridad, 'cargo' => $autoridad->cargo], 200);
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error("Se ha generado un error al momento de almacenar la autoridad", ["Modulo" => "Entidad:addAutoridad","Usuario" => Auth::user()->id.": ".Auth::user()->name, "Error" => $th->getMessage() ]);
            return response()->json(['message' => 'Se ha producido un error al momento de almacenar la autoridad. Verifique los datos ingresados.'], 203);
        }
    }

    public function destroyAutoridad(Request $request){
        $autoridad = AutoridadEntidad::find($request->id);
    
        if (!$autoridad) {
            Log::error("No se ha encontrado la autoridad que desea eliminar", ["Modulo" => "Entidad:destoryAutoridad","Usuario" => Auth::user()->id.": ".Auth::user()->name, "Error" => "Id no encontrado ".$request->id ]);
            return response()->json(['message' => 'Se ha producido un error al momento de eliminar la autoridad.'], 203);
        }
        
        $autoridad->delete();
        Log::error("Se ha actualizado correctamente la autoridad", ["Modulo" => "Entidad:destoryAutoridad","Usuario" => Auth::user()->id.": ".Auth::user()->name, "ID Autoridad" => $request->id ]);
        return response()->json(['message' => 'Se ha actualizado correctamente la autoridad'], 200);
    }
}

