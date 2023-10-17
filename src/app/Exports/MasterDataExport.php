<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class MasterDataExport implements WithMultipleSheets
{

    use Exportable;
    /**
    * @return \Illuminate\Support\Collection
    */

    function __construct() {
    }

    public function sheets(): array
    {
        $sheets = [];
        $param = [];

        $param['titles'] = ['Tipo Tramite', 'Paises','Barrios', 'Localidades', 
            'Canales Atencion', 'Cobertura Medica', 'Estado Educativo Alcanzado', 'Nivel Educativo', 
            'Tipo Documento', 'Tipo Ocupación', 'Tipo Pension', 'Situación Conyugal',
            'Programa Social', 'Parentesco (Vinculo con el Menor)', 'Sede', 'Estado CBI', 'Gabinete Psicologico', 'Escuela Primaria', 
            'Escuela Infante','Escuela Dependencia', 'Escuela Nivel (Año en Curso)', 'Turno Escolar',
            'Centro de Salud','Estado Salud'];

        for ($id = 0; $id < count($param['titles']); $id++) {
            $param['id'] = $id;
            $sheets[$id] = new MasterExport($param);
        }

        return $sheets;
    }
    
}
