<?php

namespace App\Exports;

use App\Models\Manager\Tramite;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class TramitesExport implements FromCollection, WithHeadings, WithStyles
{

    use Exportable;
    /**
    * @return \Illuminate\Support\Collection
    */

    protected $data;

    function __construct($param) {
        $this->data = $param;
        //dd(" queres cantar" . $this->data['dependencia_id']);
    }

    public function collection()
    {
        
        return Tramite::select('person.name', 'person.lastname', 'person.num_documento',DB::raw("DATE_FORMAT(person.fecha_nac, '%d-%m-%Y')"), 'localidades.description', 'escuelas.description')
            ->join('person_tramite', 'person_tramite.tramite_id', '=', 'tramites.id')
            ->join('person', 'person.id', '=', 'person_tramite.person_id')
            ->leftjoin('address_data', 'address_data.person_id', '=', 'person.id')
            ->leftjoin('education_data','education_data.person_id','=', 'person.id')
            ->leftjoin('localidades', 'localidades.id', '=', 'address_data.localidad_id')
            ->leftjoin('escuelas', 'escuelas.id', '=', 'education_data.escuela_id')
            ->where('person_tramite.rol_tramite_id', '1')
            ->where('tramites.dependencia_id', $this->data['dependencia_id'])
            ->get();
    }

    public function headings(): array
    {
        return [
            'Nombre',
            'Apellido',
            'Num. Documento',
            'Fecha Nacimiento',
            'Localidad',
            'Educación',
            'Estado Educativo',
            'Ocupación',
            'Fecha Tramite',
            'Tipo Tramite',
            'Dependencia',
            'Barrio',
            //'Nomenclatura', //No se utiliza
            'Observacion'
        ];
    }

    public function styles(Worksheet $sheet)
    {
        // Aplica un estilo a las celdas de la cabecera
        $sheet->getStyle('A1:' . $sheet->getHighestColumn() . '1')
              ->applyFromArray([
                  'font' => [
                      'bold' => true,
                    ],
                    'fill' => [
                        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                        'startColor' => [
                          'rgb' => 'CCC', // Color de fondo GRIS
                      ],
                  ],
              ]);
    }
}
