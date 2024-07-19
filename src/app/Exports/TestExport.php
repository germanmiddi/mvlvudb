<?php

namespace App\Exports;

use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use App\Models\Tramite;

class TestExport implements FromCollection, WithHeadings, WithStyles, ShouldAutoSize, WithColumnFormatting, WithTitle, WithCustomStartCell
{
    use Exportable;

    protected $data;
    protected $headers;

    function __construct(array $data, array $headers) {
        $this->data = $data;
        $this->headers = $headers;
    }

    public function collection()
    {
        $fields = [];
        foreach ($this->headers as $field) {
            switch ($field) {
                case 'Numero de Documento':
                    $fields[] = 'person.num_documento';
                    break;
                case 'Canal de Atencion':
                    $fields[] = 'modalidad_atencion_id';
                    break;
                case 'Tipo Tramite':
                    $fields[] = 'tipo_tramite_id';
                    break;
                case 'Observaciones':
                    $fields[] = 'tramites.observacion';
                    break;
                // Add additional cases as needed
                default:
                    break;
            }
        }

        $result = DB::table('tramites')
            ->select($fields)
            ->join('person_tramite', 'person_tramite.tramite_id', '=', 'tramites.id')
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

    public function startCell(): string
    {
        return 'A1';
    }

    public function title(): string
    {
        return 'Detalle Tramites';
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle('A1:' . $sheet->getHighestColumn() . '1')
        ->applyFromArray([
            'font' => [
                'bold' => true,
                'size' => 14,
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => [
                    'rgb' => 'CCCCCC',
                ]
            ],
        ]);

        $sheet->getRowDimension(1)->setRowHeight(30);
    }

    public function headings(): array
    {
        return $this->headers;
    }

    public function columnFormats(): array
    {
        return [   
        ];
    }

    public function cacheFor()
    {
        return now()->addMinutes(60);
    }
}