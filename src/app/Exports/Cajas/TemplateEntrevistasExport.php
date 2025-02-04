<?php

namespace App\Exports\Cajas;

use App\Models\Manager\Entrevista;
use Maatwebsite\Excel\Concerns\FromArray;

class TemplateEntrevistasExport implements FromArray
{
    public function array(): array
    {
        return [
            [
                'FECHA',
                'SEDE',
                'ENTREVISTADOR',
                'ESTADO',
                'TIPO_DOCUMENTO',
                'NUM_DOCUMENTO',
                'APELLIDO',
                'NOMBRE',
                'FECHA_NACIMIENTO',
                'CANT_HIJOS',
                'CANT_CONVIVIENTES',
                'TENENCIA',
                'PAGO_INQUILINO',
                'AMBIENTES',
                'OCUPACION',
                'COBERTURA_SALUD',
                'RECIBE_PENSION',
                'PROGRAMA_SOCIAL',
                'NIVEL_EDUCATIVO',
                'NIVEL_EDUCATIVO_ALCANZADO'
            ]
        ];
    }
}

