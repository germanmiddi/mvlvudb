<?php

namespace App\Exports;

use App\Models\Manager\Tramite;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Events\AfterSheet;

class TemplateDependenciaExport implements FromCollection, WithHeadings, WithStyles, ShouldAutoSize, WithColumnFormatting, WithTitle, WithCustomStartCell
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
        
        //$result = null;
        return new Collection();
    }

    // Define el inicio del archivo.
    public function startCell(): string
    {
        return 'A1';
    }

    // Titulo de la hoja de excel.
    public function title(): string
    {
        return 'Datos Formulario';
    }

    public function styles(Worksheet $sheet)
    {
        // Aplica un estilo a las celdas de la cabecera
        $sheet->getStyle('A1:' . $sheet->getHighestColumn() . '1')
        ->applyFromArray([
            'font' => [
                'bold' => true,
                'italic' => false,
                'size' => 10,
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => [
                    'rgb' => '4781ff', // Corregido el color de fondo GRIS
                ]
            ],
            'alignment' => [
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER
            ],
        ]);

       // $sheet->getStyle('A1:')->applyFromArray(['fill' => ['startColor' => ['rgb' => '4781ff']]]);
        /* $sheet->getStyle('D1:G1')->applyFromArray(['fill' => ['startColor' => ['rgb' => '8ae4f2']]]);
        $sheet->getStyle('H1:S1')->applyFromArray(['fill' => ['startColor' => ['rgb' => '61c66d']]]);
        $sheet->getStyle('T1:Y1')->applyFromArray(['fill' => ['startColor' => ['rgb' => 'd4f274']]]);
        $sheet->getStyle('Z1:AG1')->applyFromArray(['fill' => ['startColor' => ['rgb' => 'f28e8e']]]);
        $sheet->getStyle('AH1:AK1')->applyFromArray(['fill' => ['startColor' => ['rgb' => 'ff9728']]]);
        $sheet->getStyle('AL1:N1')->applyFromArray(['fill' => ['startColor' => ['rgb' => 'ff77d8']]]); */


        $sheet->getStyle('A2:' . $sheet->getHighestColumn() . '2')
        ->applyFromArray([
            'font' => [
                'bold' => false,
                'italic' => true,
                'size' => 7,
                'color' => [
                    'rgb' => 'FF0000', // Corregido el color de letra RED
                ]
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => [
                    'rgb' => 'CCCCCC', // Corregido el color de fondo GRIS
                ]
            ],
            'alignment' => [
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER
            ],
        ]);

        // Altura de la fila
        $sheet->getRowDimension(1)->setRowHeight(40);
        $sheet->getRowDimension(2)->setRowHeight(30);
    }

    // encabezados
    public function headings(): array
    {
        switch ($this->data['id']) {
            case 12:
                $title = [
                    ['NRO','FECHA','SEDE','TIPO TRAMITE','ANIO_CBI', 'ESTADO_CBI', 'GABINETE_CBI', 'COMEDOR_CBI','APELLIDO', 'NOMBRE', 'NUM_DOCUMENTO', 'NACIONALIDAD', 
                    'FECHA_NAC', 'DOMICILIO', 'ESTUDIO_ALCANZADO','OCUPACION','PROGRAMA_SOCIAL', 'PARENTESCO','TELEFONO','CELULAR', 'APELLIDO_MENOR',
                    'NOMBRE_MENOR','DNI_MENOR','FECHA_NAC_MENOR','DOMICILIO_MENOR','BARRIO_MENOR','ESCUELA_MENOR','DEPENDENCIA_ESCUELA_MENOR','LOCALIDAD_MENOR',
                    'NIVEL_EDUCATIVO_MENOR', 'ESCUELA_NIVEL_MENOR','TURNO_ESCOLAR_MENOR','PERMANENCIA_MENOR','CERTIFICADO_ESCOLAR','APTO_FISICO','LIBRETA_VACUNACION','CENTRO_SALUD','ESTADO_SALUD',
                    'AUTORIZACION_FIRMADA','USO_IMAGEN','AUTORIZACION_RETIRARSE'],
                    
                    ['Numero secuencial','Formato "DD/MM/AAAA"','Hojas (sedes)','Hojas (tipos_tramite)', 'Formato "AAAA"','Hoja (estados_cbi)','Hoja (gabinete_psicologico','SI/NO','Apellido del Responsable','Nombre del Responsable',
                    'Sin Puntos (.)', 'Hoja (paises)', 'Formato "DD/MM/AAAA"','','Hoja (escuela_nivel)','Hoja (tipo_ocupacion)','Hoja (programa_social)','Hoja (parentesco)','','','','',
                    'Sin Puntos (.)', 'Formato "DD/MM/AAAA"', '','Hoja (barrios)', 'Hoja (escuelas)','Hoja (escuela_dependencia', 'Hoja (localidades)', 'Hoja (escuela_nivel)','Hoja (escuela_grado)',
                    'Hoja (escuela_turno)','SI/NO','SI/NO','SI/NO','SI/NO','Hoja (centro_salud)','Hoja (estado_salud)','SI/NO','SI/NO','SI/NO']
                ];
                break;
            
            default:
                $title = [
                    ['NRO','FECHA','CANAL_ATENCION','TIPO_TRAMITE','OBSERVACION','APELLIDO', 'NOMBRE', 'NUM_DOCUMENTO', 'EMAIL','TELEFONO','CELULAR','NACIONALIDAD', 
                    'FECHA_NAC','LOCALIDAD','BARRIO','CALLE', 'NUMERO', 'PISO',' DPTO','NIVEL_EDUCATIVO' ,'ESTADO_EDUCATIVO','OCUPACION','PENSION','PROGRAMA_SOCIAL',
                    'COBERTURA_SALUD','SITUACION_CONYUGAL','CANTIDAD_HIJOS'],
                    
                    ['(*) Numero secuencial','(*) Formato "DD/MM/AAAA"','(*) Hojas (canal_atencion)','(*) Hojas (tipos_tramite)','Observación del tramite','(*) Apellido del Responsable','(*) Nombre del Responsable',
                    '(*) Sin Puntos (.)', 'correo electrónico','','', 'Hoja (paises)', '(*) Formato "DD/MM/AAAA"','Hoja (localidades)','Hoja (barrios)','Calle', 'Numero', 'Piso',' Dpto',
                    'Hoja (nivel_educativo)','Hoja (estado_educativo)','Hoja (tipo_ocupacion)','Hoja (tipo_pension)','Hoja (programa_social)','Hoja (cobertura_medica)','Hoja (situacion_conyugal','hijos']
                ];
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
