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

        $titles = ['tipos_tramite', 'paises','barrios', 'localidades', 
            'canales_atencion', 'cobertura_medica', 'estado_educativo_alcanzado', 'nivel_educativo', 
            'tipo_documento', 'tipo_ocupación', 'tipo_pension', 'situacion_conyugal',
            'programa_social', 'parentescos', 'sedes', 'estados_cbi', 'gabinete_psicologico', 'escuela_primaria', 
            'escuela_infante','escuela_dependencia', 'escuela_nivel', 'turno_escolar',
            'centro_salud','estado_salud'];

        for ($id = 0; $id < count($titles); $id++) {
            $param['title'] = $titles[$id];
            $param['dependencia_id'] = 12;
            $sheets[$id] = new MasterExport($param);
        }

        return $sheets;
    }
    
}
