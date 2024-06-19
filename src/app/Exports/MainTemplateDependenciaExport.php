<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class MainTemplateDependenciaExport implements WithMultipleSheets
{

    /**
    * @return \Illuminate\Support\Collection
    */

    protected $data;

    function __construct($param) {
        $this->data = $param;
    }

    public function sheets(): array
    {
        $this->data['id'];
        $sheets = [];

        $sheets[0] = new TemplateDependenciaExport($this->data);

        $titles = [
            'barrios', 
            'canal_atencion',
            'centro_salud',
            'cobertura_medica',
            'escuela_dependencia',
            'escuela_nivel',
            'escuela_primaria',
            'estados_cbi',
            'estado_educativo',
            'estado_salud',
            'localidades',
            'gabinete_psicologico',
            'nivel_educativo',
            'sedes',
            'situacion_conyugal',
            'paises',
            'parentescos',
            'programa_social',
            'tipos_tramite',
            'tipo_ocupación',
            'tipo_pension',
            'turno_escolar'
        ];

        for ($id = 1; $id <= count($titles); $id++) {
            $param['title'] = $titles[$id-1];
            $param['dependencia_id'] = $this->data['id'];
            $sheets[$id] = new MasterExport($param);
        }

        return $sheets;
    }

}
