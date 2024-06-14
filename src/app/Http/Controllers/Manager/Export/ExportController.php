<?php

namespace App\Http\Controllers\Manager\Export;

use App\Exports\EntidadesExport;
use App\Exports\MainTemplateDependenciaExport;
use App\Exports\PersonsExport;
use App\Exports\TemplateDependenciaExport;
use App\Exports\TramitesCBIExport;
use App\Exports\TramitesExport;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ExportController extends Controller
{
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
        
        return Excel::download(new TramitesExport($data), 'tramites.xlsx');
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

    public function exportTemplateDependencia($id)
    {

        $param['id'] = $id;
        return Excel::download(new MainTemplateDependenciaExport($param), 'Plantilla Importacion.xlsx');
    }
}
