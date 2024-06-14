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

        $titles = ['canal_atencion','tipos_tramite','paises','barrios', 'localidades','nivel_educativo',
                'tipo_ocupación','programa_social','parentescos','sedes',
                'estados_cbi','gabinete_psicologico','escuela_primaria',
                'escuela_dependencia', 'escuela_nivel', 'turno_escolar', 
                'centro_salud','estado_salud'];

        for ($id = 1; $id <= count($titles); $id++) {
            $param['title'] = $titles[$id-1];
            $param['dependencia_id'] = $this->data['id'];
            $sheets[$id] = new MasterExport($param);
        }

        return $sheets;
    }

}
