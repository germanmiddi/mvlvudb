<?php

namespace App\Exports;

use App\Models\Manager\Tramite;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
//use Maatwebsite\Excel\Concerns\WithCache;

use Maatwebsite\Excel\Concerns\WithTitle;

class TramitesExport implements FromCollection, WithHeadings, WithStyles, ShouldAutoSize, WithColumnFormatting, WithTitle, WithCustomStartCell
{

    use Exportable;
    /**
    * @return \Illuminate\Support\Collection
    */

    protected $data;

    function __construct($param) {
        $this->data = $param;
    }

    public function collection()
    {
        $result = Tramite::query();
        $depe = true;
        switch ($this->data['dependencia_id']) {
            case '2':
                $result->select('person.name', 
                'person.lastname', 
                'person.num_documento',
                'address_data.calle',
                'address_data.number',
                'localidades.description', 
                'contact_data.phone',
                'cobertura_medica.description AS cobertura_medica_description',
                DB::raw("DATE_FORMAT(tramites.fecha, '%d-%m-%Y')"),
                'users.name AS users_name',
                DB::raw("DATE_FORMAT(person.fecha_nac, '%d-%m-%Y')"),
                'contact_data.celular',
                'contact_data.email',
                'barrios.description as barrio_description',
                'address_data.piso',
                'address_data.dpto',
                'address_data.google_address',
                'escuelas.description AS escuela_description', 
                'estado_educativo.description AS estado_educativo',
                'tipo_ocupacion.description AS tipo_ocupacion_description',
                'tipo_tramite.description AS tipo_tramite_description',
                'dependencias.description AS dependencia_description',
                'tramites.observacion',);
                break;

            case '14':
                $result->select('person.name', 
                'person.lastname',
                'tipo_tramite.description AS tipo_tramite_description',
                'person.num_documento',
                DB::raw("DATE_FORMAT(person.fecha_nac, '%d-%m-%Y')"),
                'localidades.description', 
                'barrios.description as barrio_description',
                'address_data.calle',
                'address_data.number',
                'contact_data.phone',
                'nivel_educativo.description AS nivel_educativo_description',
                'estado_educativo.description AS estado_educativo',
                'tipo_ocupacion.description AS tipo_ocupacion_description',
                'tipo_pension.description AS tipo_pension_description',
                'cobertura_medica.description AS cobertura_medica_description',);
                break;
                
            case '8':
                $result->select(
                    'person.name', 
                'person.lastname', 
                'person.num_documento',
                    DB::raw("(
                        SELECT GROUP_CONCAT(pn.name SEPARATOR '\n') 
                        FROM person_tramite pt 
                        JOIN person pn ON pn.id = pt.person_id 
                        WHERE pt.tramite_id = tramites.id AND pt.rol_tramite_id = 2
                    ) AS children_names"),
                    DB::raw("(
                        SELECT GROUP_CONCAT(pn.lastname SEPARATOR '\n') 
                        FROM person_tramite pt 
                        JOIN person pn ON pn.id = pt.person_id 
                        WHERE pt.tramite_id = tramites.id AND pt.rol_tramite_id = 2
                    ) AS children_lastnames"),
                    DB::raw("(
                        SELECT GROUP_CONCAT(pn.num_documento SEPARATOR '\n') 
                        FROM person_tramite pt 
                        JOIN person pn ON pn.id = pt.person_id 
                        WHERE pt.tramite_id = tramites.id AND pt.rol_tramite_id = 2
                    ) AS children_documents"),
                        // DB::raw("DATE_FORMAT(person.fecha_nac, '%d-%m-%Y')"), 
                        'contact_data.phone',
                        'contact_data.celular',
                        'contact_data.email',
                        'localidades.description', 
                        'barrios.description as barrio_description',
                        'address_data.calle',
                        'address_data.number',
                        'address_data.piso',
                        'address_data.dpto',
                        // 'address_data.google_address',
                        'escuelas.description AS escuela_description', 
                        'estado_educativo.description AS estado_educativo',
                        'tipo_ocupacion.description AS tipo_ocupacion_description',
                        DB::raw("DATE_FORMAT(tramites.fecha, '%d-%m-%Y')"),
                        'tipo_tramite.description AS tipo_tramite_description',
                        'dependencias.description AS dependencia_description',
                        'users.name AS users_name',
                        'tramites.observacion');
                        
                break;
            default:
                $result->select(
                    'person.name', 
                        'person.lastname', 
                        'person.num_documento',
                        DB::raw("DATE_FORMAT(person.fecha_nac, '%d-%m-%Y')"), 
                        'contact_data.phone',
                        'contact_data.celular',
                        'contact_data.email',
                        'localidades.description', 
                        'barrios.description as barrio_description',
                        'address_data.calle',
                        'address_data.number',
                        'address_data.piso',
                        'address_data.dpto',
                        'address_data.google_address',
                        'escuelas.description AS escuela_description', 
                        'estado_educativo.description AS estado_educativo',
                        'tipo_ocupacion.description AS tipo_ocupacion_description',
                        DB::raw("DATE_FORMAT(tramites.fecha, '%d-%m-%Y')"),
                        'tipo_tramite.description AS tipo_tramite_description',
                        'dependencias.description AS dependencia_description',
                        'tramites.observacion',
                        DB::raw("IF(".$this->data['dependencia_id']." = 6, IF(tramite_data.ingreso_nuevo IS NOT NULL, IF(tramite_data.ingreso_nuevo, 'SI', 'NO'), '-'), '') AS ingreso_nuevo"),
                        DB::raw("IF(".$this->data['dependencia_id']." = 6, IF(tramite_data.boton_antipanico IS NOT NULL, IF(tramite_data.boton_antipanico, 'SI', 'NO'), '-'), '') AS boton_antipanico"));
                break;
        }
        if($this->data['dependencia_id'] !== 2){
        } else {
            
        }

        $result->join('person_tramite', 'person_tramite.tramite_id', '=', 'tramites.id')
            ->join('person', 'person.id', '=', 'person_tramite.person_id')
            ->leftjoin('users','users.id','=', 'tramites.assigned')
            ->leftjoin('education_data','education_data.person_id','=', 'person.id')
            ->leftjoin('address_data', 'address_data.person_id', '=', 'person.id')
            ->leftjoin('contact_data', 'contact_data.person_id', '=', 'person.id')
            ->leftjoin('social_data', 'social_data.person_id', '=', 'person.id')
            ->leftjoin('escuelas', 'escuelas.id', '=', 'education_data.escuela_id')
            ->leftjoin('estado_educativo', 'estado_educativo.id', '=', 'education_data.estado_educativo_id')
            ->leftjoin('nivel_educativo', 'nivel_educativo.id', '=', 'education_data.nivel_educativo_id')
            ->leftjoin('tipo_ocupacion', 'tipo_ocupacion.id', '=', 'social_data.tipo_ocupacion_id')
            ->leftjoin('tipo_pension', 'tipo_pension.id', '=', 'social_data.tipo_pension_id')
            ->leftjoin('tipo_tramite', 'tipo_tramite.id', '=', 'tramites.tipo_tramite_id')
            ->leftjoin('dependencias', 'dependencias.id', '=', 'tramites.dependencia_id')
            ->leftjoin('localidades', 'localidades.id', '=', 'address_data.localidad_id')
            ->leftjoin('barrios', 'barrios.id', '=', 'address_data.barrio_id')
            ->leftjoin('cobertura_medica', 'cobertura_medica.id', '=', 'social_data.cobertura_medica_id')
            ->leftjoin('tramite_data', 'tramite_data.tramite_id', '=', 'tramites.id')
            ->when($this->data['dependencia_id'] == 8, function ($query) {
                return $query->whereIn('person_tramite.rol_tramite_id', [1, 2]);
            }, function ($query) {
                return $query->where('person_tramite.rol_tramite_id', 1);
            })
            ->groupBy('tramites.id');

        if(isset($this->data['dependencia_id'])){
            $result->where('tramites.dependencia_id', $this->data['dependencia_id']);
        }

        if(isset($this->data['tipo_tramite_id'])){
            $result->where('tramites.tipo_tramite_id', $this->data['tipo_tramite_id']);
        }

        if(isset($this->data['from']) && isset($this->data['to'])){
            $result->where('fecha','>=', $this->data['from'])
                    ->where('fecha', '<', $this->data['to']);
        }

        if(isset($this->data['estado_id'])){
            $estado_id = json_decode($this->data['estado_id']);
            $result->where('estado_id', $estado_id);
        }

        if(isset($this->data['asigned_me'])){
            $result->where('assigned', Auth::user()->id);
        }

        if(isset($this->data['name'])){
            $name = json_decode($this->data['name']);  
            $result->whereIn('id', function ($sub) use($name) {
                        $sub->selectRaw('tramites.id')
                            ->from('tramites')
                            ->join('person_tramite', 'tramites.id', '=', 'person_tramite.tramite_id')
                            ->join('person', 'person.id', '=', 'person_tramite.person_id')
                            ->where('person.name', 'LIKE', '%'.$name.'%')
                            ->orWhere('person.lastname', 'LIKE', '%'.$name.'%');
                    });
        }
        if(isset($this->data['num_documento'])){
            $num_documento = json_decode($this->data['num_documento']);  
            $result->whereIn('id', function ($sub) use($num_documento) {
                        $sub->selectRaw('tramites.id')
                            ->from('tramites')
                            ->join('person_tramite', 'tramites.id', '=', 'person_tramite.tramite_id')
                            ->join('person', 'person.id', '=', 'person_tramite.person_id')
                            ->where('person.num_documento', 'LIKE', '%'.$num_documento.'%');
                    });
        }

        //dd($this->data['ingreso_nuevo']);
        if(isset($this->data['boton_antipanico'])){
            $boton_antipanico = json_decode($this->data['boton_antipanico']);  
        
            $result->whereIn('tramites.id', function ($sub) use($boton_antipanico) {
                        $sub->selectRaw('tramites.id')
                            ->from('tramites')
                            ->join('tramite_data', 'tramite_data.tramite_id', '=', 'tramites.id')
                            ->where('tramite_data.boton_antipanico', '=', $boton_antipanico);
                    });
        }

        if(isset($this->data['ingreso_nuevo'])){
            $ingreso_nuevo = $this->data['ingreso_nuevo'];  

            $result->whereIn('tramites.id', function ($sub) use($ingreso_nuevo) {
                        $sub->selectRaw('tramites.id')
                            ->from('tramites')
                            ->join('tramite_data', 'tramite_data.tramite_id', '=', 'tramites.id')
                            ->where('tramite_data.ingreso_nuevo', '=', $ingreso_nuevo);
                    });
        }

        if(isset($this->data['modalidad_atencion_id'])){
            $result->where('tramites.modalidad_atencion_id', $this->data['modalidad_atencion_id']);
        }

        if(isset($this->data['categoria_id'])){
            $result->where('tramites.category_id', $this->data['categoria_id']);
        }

        if(isset($this->data['user_id'])){
            $result->where('tramites.assigned', $this->data['user_id']);
        }

        return $result->get();
    }

    // Define el inicio del archivo.
    public function startCell(): string
    {
        return 'A1';
    }

    // Titulo de la hoja de excel.
    public function title(): string
    {
        return 'Detalle Tramites';
    }

    public function styles(Worksheet $sheet)
    {
        // Aplica estilos a la cabecera
        $headerRange = 'A1:' . $sheet->getHighestColumn() . '1';
        $sheet->getStyle($headerRange)
            ->applyFromArray([
                'font' => [
                    'bold' => true,
                    'size' => 14,
                ],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => [
                        'rgb' => 'CCCCCC', // Color de fondo gris
                    ],
                ],
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                ],
            ]);

        // Ajusta la altura de la fila de la cabecera
        $sheet->getRowDimension(1)->setRowHeight(30);

        // Obtén el rango completo de datos (todas las celdas no vacías)
        $highestColumn = $sheet->getHighestColumn();
        $highestRow = $sheet->getHighestRow();
        $dataRange = 'A2:' . $highestColumn . $highestRow; // Desde A2 hasta la última celda

        // Aplica centrado a todo el rango de datos
        $sheet->getStyle($dataRange)
            ->getAlignment()
            ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER)
            ->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);

        // Ajusta el ancho de todas las columnas automáticamente
        foreach (range('A', $highestColumn) as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }
    }

    // encabezados
    public function headings(): array
    {
        switch ($this->data['dependencia_id']) {
            case '2':
                $title = [
                    'Nombre',
                    'Apellido',
                    'Num. Documento',
                    'Calle',
                    'Número',
                    'Localidad',
                    'Telefono',
                    'Cobertura Social',
                    'Fecha',
                    'Profesional',
                    'Fecha Nacimiento',
                    'Celular',
                    'Email',
                    'Barrio',
                    'Piso',
                    'Dpto',
                    'Direccion Google',
                    'Escuela',
                    'Estado Educativo',
                    'Ocupación',
                    'Fecha Tramite',
                    'Tipo Tramite',
                    'Dependencia',
                    //'Nomenclatura', //No se utiliza
                    'Observacion'
                ];
            case '8':
                $title = [
                    'Nombre Denunciante',
                    'Apellido Denunciante',
                    'Num. Documento Denunciante',
                    'Nombre del Niño/s',
                    'Apellido del Niño/s',
                    'Num. Documento del Niño/s',
                    'Telefono Denunciante',
                    'Celular Denunciante',
                    'Email Denunciante',
                    'Localidad',
                    'Barrio',
                    'Calle',
                    'Número',
                    'Piso',
                    'Dpto',
                    // 'Cobertura Social',
                    'Escuela',
                    // 'Fecha',
                    'Estado Educativo',
                    // 'Direccion Google',
                    'Ocupación',
                    'Fecha Tramite',
                    'Tipo Tramite',
                    'Dependencia',
                    'Profesional',
                    //'Nomenclatura', //No se utiliza
                    'Observacion'
                ];
                break;
            case '14':
                $title = [
                    'Nombre',
                    'Apellido',
                    'Tipo Tramite',
                    'Num. Documento',
                    'Fecha Nacimiento',
                    'Localidad',
                    'Barrio',
                    'Calle',
                    'Número',
                    'Telefono',
                    'Nivel Educativo',
                    'Estado Educativo',
                    'Ocupación',
                    'Jubilación/Pensión',
                    'Cobertura Social',
                ];
                break;
            
            default:
                 $title = [
                'Nombre',
                'Apellido',
                'Num. Documento',
                'Fecha Nacimiento',
                'Telefono',
                'Celular',
                'Email',
                'Localidad',
                'Barrio',
                'Calle',
                'Numero',
                'Piso',
                'Dpto',
                'Direccion Google',
                'Escuela',
                'Estado Educativo',
                'Ocupación',
                'Fecha Tramite',
                'Tipo Tramite',
                'Dependencia',
                //'Nomenclatura', //No se utiliza
                'Observacion'
            ];
            if($this->data['dependencia_id'] === 6){
                $title[] = 'Ingreso Nuevo';
                $title[] = 'Boton Antipanico';
            }
                break;
        }

        return $title;
    }

    //Define el ancho de las columnas, si esta vacio se autoajustan
    public function columnFormats(): array
    {
        return [   
                
        ];
    }

    public function cacheFor()
    {
        // Define el tiempo en minutos durante el cual la caché debe ser válida
        return now()->addMinutes(60); // 60 minutos de caché
    }


    
}
