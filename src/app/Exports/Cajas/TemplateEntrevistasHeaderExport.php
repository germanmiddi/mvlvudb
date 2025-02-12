<?php

namespace App\Exports\Cajas;

use App\Models\Manager\Entrevista;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
class TemplateEntrevistasHeaderExport implements FromArray, WithStyles, ShouldAutoSize
{
    public function array(): array
    {
        return [
            [
                'FECHA',
                'SEDE',
                'ENTREVISTADOR',
                'OBSERVACIONES',
                'ESTADO',
                'TIPO_DOCUMENTO',
                'NUM_DOCUMENTO',
                'APELLIDO',
                'NOMBRE',
                'FECHA_NACIMIENTO',
                'EMAIL',
                'TELEFONO',
                'CELULAR',
                'LOCALIDAD',
                'BARRIO',
                'CALLE',
                'NUMERO',
                'PISO',
                'DEPARTAMENTO',
                'PAIS_DE_ORIGEN',
                'SITUACION_CONYUGAL',
                'VIVE_SOLO',
                'CANT_CONVIVIENTES',
                'HIJOS_A_CARGO',
                'CUANTOS_HIJOS_TIENE',
                'CUANTAS_PERSONAS_TRABAJAN_EN_EL_HOGAR',
                'CONVIVIENTE_CON_DISCA',
                'TENENCIA',
                'AMBIENTES',
                'NIVEL_EDUCATIVO',
                'NIVEL_EDUCATIVO_ALCANZADO',
                'OCUPACION',
                'INGRESOS_TRABAJO',
                'PERCIBE_JUBILACION_PENSION',
                'INGRESOS_PENSION',
                'PROGRAMA_SOCIAL',
                'COBERTURA_SALUD',
                'RECIBE_TRATAMIENTO_MEDICO',
                'CUAL_TRATAMIENTO_MEDICO',
                'RECIBE_MEDICACION',
                'CUAL_MEDICACION',
                'TIENE_DISCAPACIDAD',
                'NRO_CUD',
                'DIAGNOTICO'
            ],
            [
                'Fecha en que se creó la entrevista',
                'Sede donde se realizó la entrevista',
                'Nombre del entrevistador',
                'Observaciones adicionales',
                'Estado de la entrevista',
                'Tipo de documento del entrevistado',
                'Número de documento del entrevistado',
                'Apellido del entrevistado',
                'Nombre del entrevistado',
                'Nacimiento del entrevistado DD/MM/AAAA',
                'Correo electrónico de contacto',
                'Teléfono fijo',
                'Teléfono celular',
                'Localidad (Tabla Referencia)',
                'Barrio (Tabla Referencia)',
                'Calle',
                'Número',
                'Piso',
                'Departamento',
                'País de origen (Tabla Referencia)',
                'Estado civil/Situación conyugal (Tabla Referencia)',
                'Indica si vive solo (SI/NO)',
                'Cantidad de personas con las que convive',
                'Indica si tiene hijos a cargo (SI/NO)',
                'Cantidad de hijos',
                'Cantidad de personas que trabajan en el hogar',
                'Indica si convive con persona con discapacidad (SI/NO)',
                'Tipo de tenencia de la vivienda (Tabla Referencia)',
                'Cantidad de ambientes de la vivienda',
                'Nivel educativo (Tabla Referencia)',
                'Estado del nivel educativo (Tabla Referencia)',
                'Ocupación (Tabla Referencia)',
                'Ingresos por trabajo',
                'Indica si percibe jubilación o pensión (Tabla Referencia)',
                'Ingresos por jubilación/pensión',
                'Programas sociales que recibe (Tabla Referencia)',
                'Tipo de cobertura de salud (Tabla Referencia)',
                'Indica si recibe tratamiento médico (SI/NO)',
                'Tratamiento médico',
                'Indica si recibe medicación (SI/NO)',
                'Medicación',
                'Indica si tiene discapacidad (SI/NO)',
                'Número de CUD',
                'Diagnóstico médico'
            ]
        ];
    }
    public function styles(Worksheet $sheet)
    {
        // Estilo para la primera y segunda fila
        return [
            1 => [
                'font' => ['bold' => true],  // Poner el texto en negrita
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['argb' => 'CCCCCC'], // Fondo gris
                ],
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                ]
            ],
            2 => [
                // 'font' => ['bold' => true],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['argb' => 'DDDDDD'],
                ],
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                ]
            ],
        ];
    }
}

