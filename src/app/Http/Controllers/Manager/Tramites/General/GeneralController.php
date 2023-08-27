<?php

namespace App\Http\Controllers\Manager\Tramites\General;

use App\Http\Controllers\Controller;
use App\Models\Manager\Dependencia;
use App\Models\Manager\TipoTramite;
use App\Models\Manager\Tramite;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Inertia\Inertia;

class GeneralController extends Controller
{
    //index
    public function index()
    {
        return Inertia::render('Manager/Tramites/General/Index',
        [
            'tiposTramite' => TipoTramite::active()->get(),
            'dependencias' => Dependencia::all(),
            'toast' => Session::get('toast')
        ]);
    }

    //list
    public function list()
    {
        // $ids = $this->_get_id_entidades();

        // dd($ids);

        $length = request('length');
        
        $result = Tramite::query();
            //->with('person_tramite') // Carga la relación "documentos" para evitar problemas de carga perezosa (eager loading)
            //->orderBy('person_tramite.rol_tramite_id', 'asc') // Ordena los trámites por la columna "fecha" de la relación "documentos" de forma descendente
           // ->get();

           if(request('dependencia_id')){
            $dependencia_id = json_decode(request('dependencia_id'));
            $result->where('dependencia_id', $dependencia_id);
        }

        if(request('name')){
            $name = json_decode(request('name'));  
            $result->whereIn('id', function ($sub) use($name) {
                        $sub->selectRaw('tramites.id')
                            ->from('tramites')
                            ->join('person_tramite', 'tramites.id', '=', 'person_tramite.tramite_id')
                            ->join('person', 'person.id', '=', 'person_tramite.person_id')
                            ->where('person.name', 'LIKE', '%'.$name.'%')
                            ->orWhere('person.lastname', 'LIKE', '%'.$name.'%');
                    });
        }
        if(request('num_documento')){
            $num_documento = json_decode(request('num_documento'));  
            $result->whereIn('id', function ($sub) use($num_documento) {
                        $sub->selectRaw('tramites.id')
                            ->from('tramites')
                            ->join('person_tramite', 'tramites.id', '=', 'person_tramite.tramite_id')
                            ->join('person', 'person.id', '=', 'person_tramite.person_id')
                            ->where('person.num_documento', 'LIKE', '%'.$num_documento.'%');
                    });
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

        return  $result->orderBy("tramites.fecha", 'DESC')
            ->paginate($length)
            ->withQueryString()
            ->through(fn ($tramite) => [
                'tramite'   => $tramite,
                'persons'   => $tramite->persons,
                'tipo_tramite' => $tramite->tipoTramite,
                'dependencia' => $tramite->dependencia
            ]);
    }

    public function _get_id_entidades(){

        $roles_entidades = [[ 'id' => '2', 'name' => 'DISCAPACIDAD',                'rol' => '-DIS-'],
                            [ 'id' => '3', 'name' => 'ENTIDADES INTERMEDIAS',       'rol' => '-ENT-'],
                            [ 'id' => '5', 'name' => 'FORTALECIMIENTO COMUNITARIO', 'rol' => '-FOR-'],
                            [ 'id' => '6', 'name' => 'GÉNERO Y DIVERSIDAD',         'rol' => '-GEN-'],
                            [ 'id' => '7', 'name' => 'HÁBITAT',                     'rol' => '-HAB-'],
                            ['id' => '8',  'name' => 'NIÑEZ Y ADOLESCENCIA',        'rol' => '-NIN-'],
                            ['id' => '10', 'name' => 'VENTANILLA ÚNICA',            'rol' => '-VU-'],
                            ['id' => '12', 'name' => 'CENTROS BARRIALES INFANCIA',  'rol' => '-CBI-'],
                            ['id' => '13', 'name' => 'CENTROS BARRIALES JUVENTUD',  'rol' => '-CBJ-'],
                            ['id' => '14', 'name' => 'PERSONAS MAYORES',            'rol' => '-PM-'] ];

        $userGroups = session('userGroups');
        
        $filteredEntityIds = array_map(function ($userGroup) use ($roles_entidades) {
            $matchingRole = array_filter($roles_entidades, function ($roleEntidad) use ($userGroup) {
                return strpos($userGroup, $roleEntidad['rol']) !== false;
            });
        
            return $matchingRole ? reset($matchingRole)['id'] : null;
        }, $userGroups->toArray());

        $filteredEntityIds = array_filter($filteredEntityIds); // Remove null values
        
        return $filteredEntityIds;

    }
}
