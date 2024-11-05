<?php

namespace App\Http\Controllers\Manager\Report;

use App\Exports\EntidadesExport;
use App\Exports\PersonsExport;
use App\Exports\TestExport;
use App\Exports\TramitesCBIExport;
use App\Exports\TramitesExport;
use App\Exports\InscriptosCBExport;
use App\Http\Controllers\Controller;
use App\Models\Manager\Dependencia;
use App\Models\Manager\TipoTramite;
use App\Models\Manager\Tramite;
use App\Models\Manager\LegajoCB;
use App\Models\Manager\Person;
use App\Models\Manager\Cud;
use App\Models\Manager\GabineteCB;
use App\Models\Manager\CbiData;
use App\Models\Manager\CbjData;
use App\Models\Manager\TramiteEstado;
use Carbon\Carbon;
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
        $query = Tramite::query();
        
        $query = $query
        ->join('person_tramite', 'person_tramite.tramite_id', '=', 'tramites.id')
        ->join('person', 'person.id', '=', 'person_tramite.person_id');
        $columns = [];
        $titles = [];
        $uniqueNeeds = [];

        foreach ($updateOrder as $item) {
            if (isset($item['needs']) && !in_array($item['needs'], $uniqueNeeds) ) {
                $uniqueNeeds[] = $item['needs'];
            }
        }

        if(!empty($uniqueNeeds)){
            $query = $this->getLeftJoinNeeded($query, $uniqueNeeds);
        }
        foreach ($updateOrder as $item) {
            if (isset($item['needs']) && $item['needs'] != $item['table']) {
                $query = $query->leftJoin($item['table'], $item['table'] . '.id', '=', $item['needs'] . '.' . $item['joined_table_column']);
            }
            $columns[] = $item['table'] . '.' . $item['column'] . ' ' . 'as' . ' ' . $item['label'];
            $titles[] = $item['label'];
        }
        
        if (empty($columns)) {
            return response()->json(['error' => 'No hay columnas activas para exportar.'], 400);
        }
        
        $query->select($columns)->where('person_tramite.rol_tramite_id', '1');
        
        $data = $query->get();

        return Excel::download(new TestExport($data, $titles), 'tramites.xlsx');
    }

    public function getLeftJoinNeeded($query, $needs)
    {
        foreach ($needs as $need) {
            switch ($need) {
                case 'aditional_data':
                    $query->leftjoin('aditional_data', 'aditional_data.person_id', '=', 'person.id');
                    break;
                case 'education_data':
                    $query->leftjoin('education_data','education_data.person_id','=', 'person.id');
                    break;
                case 'address_data':
                    $query->leftjoin('address_data', 'address_data.person_id', '=', 'person.id');
                    break;
                case 'contact_data':
                    $query->leftjoin('contact_data', 'contact_data.person_id', '=', 'person.id');
                    break;
                case 'social_data':
                    $query->leftjoin('social_data', 'social_data.person_id', '=', 'person.id');
                    break;
                case 'salud_data':
                    $query->leftjoin('salud_data', 'salud_data.person_id', '=', 'person.id');
                    break;
                case 'tramites':
                    break;
                
                default:
                    break;
            }
        }
        return $query;
    }
    public function exportTramiteCBIExcel(){
        return Excel::download(new TramitesCBIExport(), 'tramitesCBI.xlsx');
    }

    public function exportInscriptosCBExcel(Request $request){

        $cuds = Cud::with('person')->get();

        $cbsJI = CbiData::with('estadoCbi', 'estadoGabineteCb')->get()
            ->merge(
                CbjData::with('estadoCbj', 'acompanamiento')->get()
            );
        $gabinetes = GabineteCB::with('legajo', 'estado')->get();
        
        $values = [];
        //Filtros
        //Escuela, Estado, Tipo Legajo, Sede, Edades
        // if($request->escuela){
        //     $values['escuela'] = json_decode($request->escuela);
        // }

        $cbsQuery = LegajoCB::with('responsable', 'autorizacion', 'sede', 'canal_atencion', 'estadocbj', 'autorizacion', 'tipo_legajo', 'parentesco', 'gabinete');

        // Filtros
        if ($request->estado_id) {
            $cbsQuery->where('estado_id', $request['estado_id']);
        }
        
        if ($request->tipo_legajo_id) {
            $cbsQuery->where('tipo_legajo_id', $request['tipo_legajo_id']);
            $values['tipo_legajo_id'] = json_decode($request->tipo_legajo_id);
        } else {
            $values['tipo_legajo_id'] = [1, 2]; // Valor por defecto
        }
        
        if ($request->sede_id) {
            $cbsQuery->where('sede_id', $request['sede_id']);
        }

        $cbs = $cbsQuery->get();
        
        $personIds = ($request->sede_id || $request->tipo_legajo_id || $request->estado_id) ? $cbs->pluck('person_id')->toArray() : [];
        
        $personsQuery = Person::with('address', 'education', 'tipoDoc');

        // Aplicar los filtros de edad
        if (isset($request['min_years']) && isset($request['max_years'])) {
            $today = Carbon::today();
            $minYears = (int)$request['min_years'];
            $maxYears = (int)$request['max_years'];

            //Se busca personas que nacieron despues de $min_birthdate
            $min_birthdate = $today->copy()->subYears($maxYears + 1)->startOfDay(); // Cumpleaños +1 para incluir el año
            $personsQuery->where('fecha_nac', '>=', $min_birthdate);

            //Se busca personas que nacieron despues de $max_birthdate
            $max_birthdate = $today->copy()->subYears($minYears)->endOfDay(); // Fin del día del cumpleaños
            $personsQuery->where('fecha_nac', '<=', $max_birthdate);

            //Se filtra a las personas reescribiendo la variable de id de personas
            $finalPersons = $personsQuery->whereIn('id', $personIds)->get();
            $personIds = $finalPersons->pluck('id')->toArray();
        }
        
        $persons = Person::with('address', 'education', 'tipoDoc')->get();
        
        //Ver como hacer con el tema de tipo de trámite
        //Ya que estan 144,145,146 (barrial, juventud, infancia)
        switch ($request->tipo_legajo_id) {
            case '1':
                $values['tipo_tramite_id'] = [146];
                $values['dependencia_id'] = [12];
                break;
            case '2':
                $values['tipo_tramite_id'] = [145];
                $values['dependencia_id'] = [13];
                break;
            default:
                $values['tipo_tramite_id'] = [144, 145, 146];
                $values['dependencia_id'] = [1, 12, 13];
                break;
        }
        $titles = [
                    //Trámite
                    'Id',
                    'Fecha',
                    'Observacion',
                    'Tipo de Trámite',
                    'Dependencia',
                    'Estado Tramite',
                    'Asignado',
                    'Email del Asignado',
        
                    //Person
                    'Nombre',
                    'Apellido',
                    'Edad',
                    'Tipo Documento',
                    'Documento',
                    'Fecha de Nacimiento',
                    'Telefono',
                    'Celular',
                    'Email',
        
                    //LegajoCB
                    'Nro Legajo',
                    'Sede',
                    'Estado Legajo',
                    'Canal de Atencion',
                    'Tipo Legajo',
                    'Apoyo Escolar',
                    'Actividad Por Area Empleo',
                    'Autorizacion Firmada',
                    'Autorizacion Retirarse',
                    'Autorizacion Uso de Imagen',
                    
                    //Adulto Responsable
                    'Adulto Nombre',
                    'Adulto Apellido',
                    'Adulto Documento',
                    'Adulto Parentesco',
        
                    //Direccion
                    'Localidad',
                    'Calle',
                    'Numero',
                    'Piso',
                    'Dpto',
                    'Observacion',
        
                    //Salud
                    'Apto medico',
                    'Fecha de Apto Medico',
                    'Fecha de Venc Apto Medico',
                    'Electrocardiograma',
                    'Fecha Electrocardiograma',
                    'Libreta Vacunacion',
                    'Centro de Salud',
                    'Observacion',
                    //Cud
                    'Posee Cud',
                    'Presento Cud',
                    'Cud Vencimiento',
        
                    //Educación
                    'Escuela',
                    'Nivel Educativo',
                    'Grado/Año',
                    'Estado Educativo',
                    'Turno',
                    'Dependencia',
                    'Localidad',
                    'Realiza Permanencia',
                    'Observacion',
        
                    //CBData
                    'Año Inicio',
                    'Estado CB',
                    'Estado Gabinete',
                    'Acompañamiento',
                ];

        return Excel::download(new InscriptosCBExport($values, $titles, $persons, $cbs, $cuds, $cbsJI, $gabinetes, $personIds), 'InscriptosCB.xlsx');
    }
    
    // if($request->date){

    //     $values['from'] = date('Y-m-d', strtotime($request->date[0]));
    //     $values['to'] = date('Y-m-d', strtotime("+1 day", strtotime($request->date[1]))); 
               
    // }
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
