<?php

namespace App\Exports;

use App\Models\Manager\Barrio;
use App\Models\Manager\CanalAtencion;
use App\Models\Manager\CentroSalud;
use App\Models\Manager\CoberturaMedica;
use App\Models\Manager\Escuela;
use App\Models\Manager\EscuelaDependencia;
use App\Models\Manager\EscuelaNivel;
use App\Models\Manager\EscuelaTurno;
use App\Models\Manager\EstadoCbi;
use App\Models\Manager\EstadoEducativo;
use App\Models\Manager\EstadoGabinete;
use App\Models\Manager\EstadoSalud;
use App\Models\Manager\Localidad;
use App\Models\Manager\NivelEducativo;
use App\Models\Manager\Pais;
use App\Models\Manager\Parentesco;
use App\Models\Manager\ProgramaSocial;
use App\Models\Manager\Sede;
use App\Models\Manager\SituacionConyugal;
use App\Models\Manager\TipoDocumento;
use App\Models\Manager\TipoOcupacion;
use App\Models\Manager\TipoPension;
use App\Models\Manager\TipoTramite;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
//use Maatwebsite\Excel\Concerns\WithCache;

use Maatwebsite\Excel\Concerns\WithTitle;

class MasterExport implements FromCollection, WithHeadings, WithStyles, ShouldAutoSize, WithColumnFormatting, WithTitle, WithCustomStartCell
{

    use Exportable;
    /**
    * @return \Illuminate\Support\Collection
    */

    protected $data;
    protected $FamiliarConviviente = ['Madre', 'Padre', 'Abuela/o', 'Adulto/a Responsable', 'Hermana/o Mayor de Edad', 'Tia/o', 'Madrastra/Padrastro', 'Pareja Conviviente', 'Hija/o Hijastro/a', 'Hermana/o Menor de Edad', 'Otro Familiar'];
    protected $sedesAvailables = ['La Loma', 'El Ceibo', 'Habana', 'Las Flores', 'Sivori'];
    protected $title = '';

    function __construct($param) {
        $this->data = $param;
    }

    public function collection()
    {
        switch ($this->data['title']) {
            case 'tipos_tramite':
                return TipoTramite::select('id','description')->where('dependencia_id', $this->data['dependencia_id'])->active()->get();
                break;

            case 'paises':
                return Pais::select('id','description')->get();
                break;

            case 'barrios':
                return Barrio::select('id','description')->get();
                break;
                
            case 'localidades':
                return Localidad::select('id','description')->get();
                break;

            case 'canales_atencion':
                return CanalAtencion::select('id','description')->get();
                break;

            case 'cobertura_medica':
                return CoberturaMedica::select('id','description')->get();
                break;
            
            case 'estado_educativo':
                return EstadoEducativo::select('id','description')->get();
                break;

            case 'nivel_educativo':
                return NivelEducativo::select('id','description')->get();
                break;

            case 'tipo_documento':
                return TipoDocumento::select('id','description')->get();
                break;

            case 'tipo_ocupación':
                return TipoOcupacion::select('id','description')->get();
                break;

            case 'tipo_pension':
                return TipoPension::select('id','description')->get();
                break;

            case 'situacion_conyugal':
                return SituacionConyugal::select('id','description')->get();
                break;

            case 'programa_social':
                return ProgramaSocial::select('id','description')->get();
                break;

            case 'parentescos':
                return Parentesco::whereIn('description', $this->FamiliarConviviente)->get();
                break;

            case 'sedes':
                return Sede::whereIn('description', $this->sedesAvailables)->get();
                break;

            case 'estados_cbi':
                return EstadoCbi::select('id','description')->get();
                break;
                
            case 'gabinete_psicologico':
                return EstadoGabinete::select('id','description')->get();
                break;
                
            case 'escuela_primaria':
                return Escuela::select('id','description')->where('primaria', true)->where('dependencia_id',$this->data['dependencia_id'])->get();
                break;

            case 'escuela_infante':
                return Escuela::select('id','description')->where('infante', true)->where('dependencia_id',$this->data['dependencia_id'])->get();
                break;

            case 'escuela_dependencia':
                return EscuelaDependencia::select('id','description')->get();
                break;

            case 'escuela_nivel':
                return EscuelaNivel::select('id','description')->get();
                break;
                
            case 'turno_escolar':
                return EscuelaTurno::select('id','description')->get();
                break;

            case 'centro_salud':
                return CentroSalud::where('activo', true)->get();
                break;
                
            case 'estado_salud':
                return EstadoSalud::where('activo', true)->get();
                break;
            case 'canal_atencion':
                return CanalAtencion::get();
                break;
            default:
                # code...
                break;
        }
    }

    // Define el inicio del archivo.
    public function startCell(): string
    {
        return 'A1';
    }

    // Titulo de la hoja de excel.
    public function title(): string
    {
        return $this->data['title'];
    }

    public function styles(Worksheet $sheet)
    {
        // Aplica un estilo a las celdas de la cabecera
        $sheet->getStyle('A1:' . $sheet->getHighestColumn() . '1')
        ->applyFromArray([
            'font' => [
                'bold' => true,
                'size' => 14,
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => [
                    'rgb' => 'CCCCCC', // Corregido el color de fondo GRIS
                ]
            ],
        ]);

        $sheet->getRowDimension(1)->setRowHeight(30);
    }
    
    // encabezados
    public function headings(): array
    {
        return [
                'ID',
                'Descripción',
        ];
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
