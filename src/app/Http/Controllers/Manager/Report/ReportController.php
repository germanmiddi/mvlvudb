<?php

namespace App\Http\Controllers\Manager\Report;

use App\Exports\EntidadesExport;
use App\Exports\PersonsExport;
use App\Exports\TestExport;
use App\Exports\TramitesCBIExport;
use App\Exports\TramitesExport;
use App\Http\Controllers\Controller;
use App\Models\Manager\Dependencia;
use App\Models\Manager\TipoTramite;
use App\Models\Manager\Tramite;
use App\Models\Manager\TramiteEstado;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller
{
    public function index()
    {
        return Inertia::render('Manager/Report/Index',
        [
            'tiposTramite' => TipoTramite::active()->get(),
            'dependencias' => Dependencia::all(),
            'estados' => TramiteEstado::all()
        ]);
    }

    public function summary()
    {
        //$length = request('length');
        
        $result = Tramite::query();
            //->with('person_tramite') // Carga la relación "documentos" para evitar problemas de carga perezosa (eager loading)
            //->orderBy('person_tramite.rol_tramite_id', 'asc') // Ordena los trámites por la columna "fecha" de la relación "documentos" de forma descendente
           // ->get();

        if(request('dependencia_id')){
            $dependencia_id = json_decode(request('dependencia_id'));
            $result->where('dependencia_id', $dependencia_id);
        }

        if(request('date')){
            $date = json_decode(request('date'));

            $from = date('Y-m-d', strtotime($date[0]));
            $to = date('Y-m-d', strtotime("+1 day", strtotime($date[1]))); 
                   
            $result->where('fecha','>=', $from)
                    ->where('fecha', '<', $to);
        }
        if(request('tipo_tramite_id')){
            $tipo_tramite_id = json_decode(request('tipo_tramite_id'));
            $result->where('tipo_tramite_id', $tipo_tramite_id);
        }

        return  $result->count();
    }

    public function exportTramiteExcel(Request $request){
        $data = [];

        if($request->date){

            $data['from'] = date('Y-m-d', strtotime($request->date[0]));
            $data['to'] = date('Y-m-d', strtotime("+1 day", strtotime($request->date[1]))); 
                   
        }
        if($request->dependencia_id){
            $data['dependencia_id'] = json_decode($request->dependencia_id);
        }

        if($request->tipo_tramite_id){
            $data['tipo_tramite_id'] = json_decode($request->tipo_tramite_id);
        }

        if($request->estado_id){
            $data['estado_id'] = json_decode($request->estado_id);
        }

        if($request->asigned_me){
            $data['asigned_me'] = json_decode($request->asigned_me);
        }

        if($request->name){
            $data['name'] = json_decode($request->name);
        }

        if($request->num_documento){
            $data['num_documento'] = json_decode($request->num_documento);
        }

        if(isset($request->ingreso_nuevo)){
            $data['ingreso_nuevo'] = json_decode($request->ingreso_nuevo);
        }

        if(isset($request->boton_antipanico)){
            $data['boton_antipanico'] = json_decode($request->boton_antipanico);
        } 

        if(isset($request->modalidad_atencion_id)){
            $data['modalidad_atencion_id'] = json_decode($request->modalidad_atencion_id);
        } 

        if(isset($request->categoria_id)){
            $data['categoria_id'] = json_decode($request->categoria_id);
        } 

        if($request->user_id){
            $data['user_id'] = json_decode($request->user_id);
        }
        
        return Excel::download(new TramitesExport($data), 'tramites.xlsx');
    }
    public function exportTest(Request $request){
        $updateOrder = $request->input('updateOrder');
        $filteredArray = array_filter($updateOrder, function ($item) {
            return $item['is_active'];
        });

        $query = Tramite::query();
        $query = $query->join('person_tramite', 'person_tramite.tramite_id', '=', 'tramites.id')
        ->join('person', 'person.id', '=', 'person_tramite.person_id')
        ->leftjoin('education_data','education_data.person_id','=', 'person.id')
        ->leftjoin('address_data', 'address_data.person_id', '=', 'person.id')
        ->leftjoin('contact_data', 'contact_data.person_id', '=', 'person.id')
        ->leftjoin('social_data', 'social_data.person_id', '=', 'person.id')
        ->leftjoin('escuelas', 'escuelas.id', '=', 'education_data.escuela_id')
        ->leftjoin('estado_educativo', 'estado_educativo.id', '=', 'education_data.estado_educativo_id')
        ->leftjoin('tipo_ocupacion', 'tipo_ocupacion.id', '=', 'social_data.tipo_ocupacion_id')
        ->leftjoin('tipo_tramite', 'tipo_tramite.id', '=', 'tramites.tipo_tramite_id')
        ->leftjoin('dependencias', 'dependencias.id', '=', 'tramites.dependencia_id')
        ->leftjoin('localidades', 'localidades.id', '=', 'address_data.localidad_id')
        ->leftjoin('barrios', 'barrios.id', '=', 'address_data.barrio_id')
        ->leftjoin('tramite_data', 'tramite_data.tramite_id', '=', 'tramites.id')
        ->where('person_tramite.rol_tramite_id', '1');
        $columns = [];
        $titles = [];
        foreach ($filteredArray as $item) {
            switch ($item['name']){
                case 'Nombre':
                    $columns[] = 'person.name as Nombre';
                    break;
                case 'Apellido':
                    $columns[] = 'person.lastname as Apellido';
                    break;
                case 'Numero de Documento':
                    $columns[] = 'person.num_documento as Numero de Documento';
                    break;
            }
            $titles[] = $item['name'];
        }
    
        if (empty($columns)) {
            return response()->json(['error' => 'No hay columnas activas para exportar.'], 400);
        }
    
        $query->select($columns);
        
        $data = $query->get();
        // dd($data);
        return Excel::download(new TestExport($data, $titles), 'tramites.xlsx');
        
        
        
        
        
        // $data = [$request];
        // if($request->dependencia_id){
        //     $data['dependencia_id'] = json_decode($request->dependencia_id);
        // }
        // return Excel::download(new TestExport($request), 'tramitesTest.xlsx');
       // Extrae los datos del request en un arreglo
        
    //    $headers 
    //    $data = $request->only([
    //     'dependencia_id',
    //     'tipo_tramite_id',
    //     'from',
    //     'to',
    //     'estado_id',
    //     'asigned_me',
    //     'name',
    //     'num_documento',
    //     'boton_antipanico',
    //     'ingreso_nuevo',
    //     'modalidad_atencion_id',
    //     'categoria_id',
    //     'user_id'
    // ]);
    // Si algunos valores están vacíos o no existen en el request, podrían no ser necesarios
    // $data = array_filter($data);
    }

    public function exportTramiteCBIExcel(){
        return Excel::download(new TramitesCBIExport(), 'tramitesCBI.xlsx');
    }

    public function exportPersonsExcel(Request $request){
        $data = [];

        if($request->lastname){
            $data['lastname'] = $request->lastname;
        }

        if($request->name){
            $data['name'] = $request->name;
        }

        if($request->num_documento){
            $data['num_documento'] = json_decode($request->num_documento);
        }

        if($request->localidad){
            $data['localidad'] = json_decode($request->localidad);
        }

        if($request->barrio){
            $data['barrio'] = json_decode($request->barrio);
        }

        return Excel::download(new PersonsExport($data), 'persons.xlsx');
    }

    public function exportEntidadExcel(Request $request){
        $data = [];

        if($request->name){
            $data['name'] = json_decode($request->name);
        }

        if($request->num_entidad){
            $data['num_entidad'] = json_decode($request->num_entidad);
        }

        if($request->tipo_entidad_id){
            $data['tipo_entidad_id'] = json_decode($request->tipo_entidad_id);
        }


        return Excel::download(new EntidadesExport($data), 'entidades.xlsx');
    }

}
