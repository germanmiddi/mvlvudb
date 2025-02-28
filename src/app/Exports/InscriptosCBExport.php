<?php

namespace App\Exports;

use App\Models\Manager\CbiData;
use App\Models\Manager\CbjData;
use App\Models\Manager\Person;
use App\Models\Manager\Tramite;
use App\Models\Manager\LegajoCB;
use App\Models\Manager\Cud;
use App\Models\Manager\GabineteCB;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
//use Maatwebsite\Excel\Concerns\WithCache;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\FromQuery;

use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Font;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Borders;

use Maatwebsite\Excel\Concerns\WithTitle;

class InscriptosCBExport implements WithStyles, FromView, ShouldAutoSize
{

    use Exportable;
    /**
     * @return \Illuminate\Support\Collection
     */

    protected $values;
    protected $data;
    protected $headings;
    protected $titles;
    protected $persons;
    protected $cbs;
    protected $cuds;
    protected $cbsJI;
    protected $gabinetes;
    protected $personIds;

    function __construct($values, $titles, $persons, $cbs, $cuds, $cbsJI, $gabinetes, $personIds)
    {
        $this->values = $values;
        $this->titles = $titles;
        $this->persons = $persons;
        $this->cbs = $cbs;
        $this->cuds = $cuds;
        $this->cbsJI = $cbsJI;
        $this->gabinetes = $gabinetes;
        $this->personIds = $personIds;
    }

    public function view(): view
    {
        $values = $this->values;
        $titles = $this->titles;
        $persons = $this->persons;
        $cbs = $this->cbs;
        $cuds = $this->cuds;
        $cbsJI = $this->cbsJI;
        $gabinetes = $this->gabinetes;
        $personIds = $this->personIds;
        $result = Tramite::query();
        $pos = 0;


        $tramitesQuery = Tramite::whereIn('dependencia_id', $values['dependencia_id'])
            ->with(['canalAtencion', 'sede', 'tipoTramite', 'dependencia', 'parentesco', 'estado', 'assigned', 'category', 'modalidadAtencion', 'rol_tramite']);

        // Filtra por person_id si no está vacio
        if (!empty($personIds)) {
            $tramitesQuery->whereHas('persons', function ($query) use ($personIds) {
                $query->whereIn('person_id', $personIds)
                    ->where('rol_tramite_id', '!=', 2);
            });
        }
        $tramites = $tramitesQuery->get();

        foreach ($tramites as $tramite) {

            $query = DB::table('person_tramite')->where('tramite_id', $tramite->id)->where('rol_tramite_id', '!=', 2);
            $person_tramite = $query->get();

            foreach ($person_tramite as $pt) {
                // Recorro las personas asociadas, y se cargan los datos del tramite. 
                $data_temp = [];
                $data_temp['Id'] = $tramite['id'] + 12000000;
                $data_temp['Fecha'] = $tramite->getFecha();
                $data_temp['Observacion'] = $tramite['observacion'];
                $data_temp['Tipo de Trámite'] = $tramite->tipoTramite->description;
                $data_temp['Dependencia'] = $tramite->dependencia->description;
                $data_temp['Estado Tramite'] = $tramite->estado->description;
                $data_temp['Asignado'] = $tramite->assigned->name ?? null;
                $data_temp['Email del Asignado'] = User::where('users.id', $tramite['assigned'])->first()->email ?? '';

                //Person
                $person = $persons->where('id', $pt->person_id)->first();

                $data_temp['Nombre'] = $person->name;
                $data_temp['Apellido'] = $person->lastname;
                $data_temp['Edad'] = $person->getAgeAttribute();
                $data_temp['Tipo Documento'] = $person->tipoDoc->description;
                $data_temp['Documento'] = $person->num_documento;
                $data_temp['Fecha de Nacimiento'] = $person->fecha_nac;
                $data_temp['Telefono'] = $person->contact[0]->phone ?? null;
                $data_temp['Celular'] = $person->contact[0]->celular ?? null;
                $data_temp['Email'] = $person->contact[0]->email ?? null;
                //LegajoCBData
                $cb = $cbs->where('person_id', $pt->person_id)->first();

                if (isset($cb)) {
                    $data_temp['Nro Legajo'] = $cb->id;
                    $data_temp['Sede'] = $cb->sede->description ?? null;
                    $data_temp['Estado Legajo'] = $cb->estadocbj->description ?? null;
                    $data_temp['Canal de Atencion'] = $cb->canal_atencion->description ?? null;
                    $data_temp['Tipo Legajo'] = $cb->tipo_legajo->description ?? null;
                    $data_temp['Apoyo Escolar'] = !empty($cb->autorizacion->apoyo_escolar) && $cb->autorizacion->apoyo_escolar == 1 ? 'Si' : 'No';
                    $data_temp['Actividad Por Area Empleo'] = !empty($cb->autorizacion->actividad_empleo) && $cb->autorizacion->actividad_empleo == 1 ? 'Si' : 'No';
                    $data_temp['Autorizacion Firmada'] = !empty($cb->autorizacion->autorizacion_firmada) && $cb->autorizacion->autorizacion_firmada == 1 ? 'Si' : 'No';
                    $data_temp['Autorizacion Retirarse'] = !empty($cb->autorizacion->autorizacion_retirarse) && $cb->autorizacion->autorizacion_retirarse == 1 ? 'Si' : 'No';
                    $data_temp['Autorizacion Uso de Imagen'] = !empty($cb->autorizacion->autorizacion_uso_imagen) && $cb->autorizacion->autorizacion_uso_imagen == 1 ? 'Si' : 'No';
                } else {
                    $data_temp['Nro Legajo'] = null;
                    $data_temp['Sede'] = null;
                    $data_temp['Estado Legajo'] = null;
                    $data_temp['Canal de Atencion'] = null;
                    $data_temp['Tipo Legajo'] = null;
                    $data_temp['Apoyo Escolar'] = null;
                    $data_temp['Actividad Por Area Empleo'] = null;
                    $data_temp['Autorizacion Firmada'] = null;
                    $data_temp['Autorizacion Retirarse'] = null;
                    $data_temp['Autorizacion Uso de Imagen'] = null;
                }

                //Adulto Responsable
                if (isset($cb->responsable_id)) {
                    $data_temp['Adulto Nombre'] = $cb->responsable->lastname ?? null;
                    $data_temp['Adulto Apellido'] = $cb->responsable->name ?? null;
                    $data_temp['Adulto Documento'] = $cb->responsable->num_documento ?? null;
                    $data_temp['Adulto Parentesco'] = $cb->parentesco->description ?? null;
                } else {
                    $data_temp['Adulto Nombre'] = null;
                    $data_temp['Adulto Apellido'] = null;
                    $data_temp['Adulto Documento'] = null;
                    $data_temp['Adulto Parentesco'] = null;
                }

                //Data_address
                $data_temp['Localidad'] = !empty($person->address[0]->localidad_id) ? $person->address[0]->localidad->description : null;
                $data_temp['Calle'] = !empty($person->address[0]->calle) ? $person->address[0]->calle : null;
                $data_temp['Numero'] = !empty($person->address[0]->number) ? $person->address[0]->number : null;
                $data_temp['Piso'] = !empty($person->address[0]->piso) ? $person->address[0]->piso : null;
                $data_temp['Dpto'] = !empty($person->address[0]->dpto) ? $person->address[0]->dpto : null;
                $data_temp['Observacion'] = !empty($person->address[0]->observacion) ? $person->address[0]->observacion : null;


                // Data_salud
                if ($person->salud) {
                    $data_temp['Apto medico'] = $person->salud->apto_medico == 1 ? 'Si' : ($person->salud->apto_medico === null ? 'No' : 'No');
                    $data_temp['Fecha de Apto Medico'] = $person->salud->fecha_apto_medico ?? null;
                    $data_temp['Fecha de Venc Apto Medico'] = $person->salud->fecha_apto_medico ?? null;
                    $data_temp['Electrocardiograma'] = $person->salud->electrocardiograma == 1 ? 'Si' : ($person->salud->electrocardiograma === null ? 'No' : 'No');
                    $data_temp['Fecha Electrocardiograma'] = $person->salud->fecha_electrocardiograma ?? null;
                    $data_temp['Libreta Vacunacion'] = $person->salud->libreta_vacunacion == 1 ? 'Si' : ($person->salud->libreta_vacunacion === null ? 'No' : 'No');
                    $data_temp['Centro de Salud'] = !empty($person->salud->centro_salud_id) ? $person->salud->centroSalud->description : null;
                    $data_temp['Observacion'] = $person->salud->observacion ?? null;

                } else {
                    $data_temp['Apto medico'] = null;
                    $data_temp['Fecha de Apto Medico'] = null;
                    $data_temp['Fecha de Venc Apto Medico'] = null;
                    $data_temp['Electrocardiograma'] = null;
                    $data_temp['Fecha Electrocardiograma'] = null;
                    $data_temp['Libreta Vacunacion'] = null;
                    $data_temp['Centro de Salud'] = null;
                    $data_temp['Observacion'] = null;
                }

                //CUD
                $cud = $cuds->where('person_id', $person->id)->first();
                if (isset($cud)) {
                    $data_temp['Posee Cud'] = $cud->posee_cud === null ? 'No' : ($cud->posee_cud == 1 ? 'Si' : 'No');
                    $data_temp['Presento Cud'] = $cud->presento_cud === null ? 'No' : ($cud->presento_cud == 1 ? 'Si' : 'No');
                    $data_temp['Cud Vencimiento'] = $cud->getFecha() ?? null;
                } else {
                    $data_temp['Posee Cud'] = 'No';
                    $data_temp['Presento Cud'] = 'No';
                    $data_temp['Cud Vencimiento'] = null;
                }
                // Data_education
                // switch ($person) {
                //     case ($person->education[0]->escuela_id) !== null:
                //         $data_temp['Escuela'] = $person->education[0]->escuelaPrimaria->description;
                //         break;
                //     case ($person->education[0]->escuela_infante_id) !== null:
                //         $data_temp['Escuela'] = $person->education[0]->escuelaPrimaria->description;
                //         break;
                //     case ($person->education[0]->escuela_primaria_id) !== null:
                //         $data_temp['Escuela'] = $person->education[0]->escuelaPrimaria->description;
                //         break;
                //     case ($person->education[0]->escuela_secundaria_id) !== null:
                //         $data_temp['Escuela'] = $person->education[0]->escuelaPrimaria->description;
                //         break;
                //     case ($person->education[0]->escuela_nocturna_id) !== null:
                //         $data_temp['Escuela'] = $person->education[0]->escuelaPrimaria->description;
                //         break;

                //     default:
                //         $data_temp['Escuela'] = null;
                //         break;
                // }
                $data_temp['Escuela'] = isset($person->education[0]->escuela_primaria_id) && $person->education[0]->escuelaPrimaria !== null ? $person->education[0]->escuelaPrimaria->description : null;
                $data_temp['Nivel Educativo'] = isset($person->education[0]->nivel_educativo_id) ? $person->education[0]->nivelEducativo->description : null;
                $data_temp['Grado/Año'] = isset($person->education[0]->escuela_nivel_id) ? $person->education[0]->escuelaNivel->description : null;
                $data_temp['Estado Educativo'] = isset($person->education[0]->estado_educativo_id) ? $person->education[0]->estadoEducativo->description : null;
                $data_temp['Turno'] = isset($person->education[0]->escuela_turno_id) ? $person->education[0]->escuelaTurno->description : null;
                $data_temp['Dependencia'] = isset($person->education[0]->escuela_dependencia_id) ? $person->education[0]->escuelaDependencia->description : null;
                $data_temp['Localidad'] = isset($person->education[0]->escuela_localidad_id) ? $person->education[0]->escuelaLocalidad->description : null;
                $data_temp['Realiza Permanencia'] = isset($person->education[0]->permanencia) && $person->education[0]->permanencia == 1 ? 'Si' : 'No';
                $data_temp['Observacion'] = $person->education[0]->observacion ?? null;

                //CB DATA
                $cbJI = $cbsJI->where('tramite_id', $tramite->id)->first();
                $data_temp['Año Inicio'] = $cbJI->anio_inicio ?? null;


                $data_temp['Estado CB'] =
                    isset($cbJI->estado_cbi_id) ?
                    ($cbJI->estadoCbi ? $cbJI->estadoCbi->description : null) : (isset($cbJI->estado_cbj_id) ?
                        ($cbJI->estadoCbj ? $cbJI->estadoCbj->description : null) : null);


                $gabinete = isset($cb) ? $gabinetes->where('legajo_id', $cb->id)->first() : null;
                $data_temp['Estado Gabinete'] = isset($gabinete->estado_id) ? $gabinete->estado->description : null;
                $data_temp['Acompañamiento'] = isset($cbJI->acompanamiento_cbj_id) ? $cbJI->acompanamiento->description : null;


                $this->data[$pos] = $data_temp;
                $pos++;
            }
        }
        $data = collect($this->data)->toArray();

        return view('exports.inscriptos', [
            'data' => $data,
            'titles' => $titles,
        ]);
    }

    // Define el inicio del archivo.
    public function startCell(): string
    {
        return 'A1';
    }

    // Titulo de la hoja de excel.
    public function title(): string
    {
        return 'Detalle Tramites';
    }

    public function styles(Worksheet $sheet)
    {
        $lastColumn = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex(count($this->titles));
        $headerRange = "A1:{$lastColumn}1";

        $sheet->getStyle($headerRange)->applyFromArray([
            'font' => [
                'bold' => true,
                'size' => 14,
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => [
                    'rgb' => '4CAF50'
                ]
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
                'justify' => Alignment::HORIZONTAL_JUSTIFY,
            ],
            'borders' => [
                'outline' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['rgb' => '000000'],
                ],
            ]
        ]);

        $sheet->getStyle("A1:{$lastColumn}" . $sheet->getHighestRow())->applyFromArray([
            'alignment' => [
                'wrapText' => true,
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ]
        ]);


        return [];
    }

    //Define el ancho de las columnas, si esta vacio se autoajustan

    public function cacheFor()
    {
        // Define el tiempo en minutos durante el cual la caché debe ser válida
        return now()->addMinutes(60); // 60 minutos de caché
    }



}
