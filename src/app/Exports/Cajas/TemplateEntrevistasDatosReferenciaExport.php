<?php

namespace App\Exports\Cajas;

use App\Models\Manager\Entrevista;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;


class TemplateEntrevistasDatosReferenciaExport implements FromArray, WithStyles, ShouldAutoSize
{
    protected $puntosEntrega;
    protected $entrevistadores;
    protected $tipoDocumento;
    protected $situacionConyugal;
    protected $paises;
    protected $tenencia;
    protected $ocupacion;
    protected $coberturaMedica;
    protected $tipoPension;
    protected $programaSocial;
    protected $nivelEducativo;
    protected $estadoEducativo;
    protected $entrevistasStatus;

    public function __construct($puntosEntrega, $entrevistadores, $tipoDocumento, $situacionConyugal, $paises, $tenencia, $ocupacion, $coberturaMedica, $tipoPension, $programaSocial, $nivelEducativo, $estadoEducativo, $entrevistasStatus)
    {
        $this->puntosEntrega = $puntosEntrega;
        $this->entrevistadores = $entrevistadores;
        $this->tipoDocumento = $tipoDocumento;
        $this->situacionConyugal = $situacionConyugal;
        $this->paises = $paises;
        $this->tenencia = $tenencia;
        $this->ocupacion = $ocupacion;
        $this->coberturaMedica = $coberturaMedica;
        $this->tipoPension = $tipoPension;
        $this->programaSocial = $programaSocial;
        $this->nivelEducativo = $nivelEducativo;
        $this->estadoEducativo = $estadoEducativo;
        $this->entrevistasStatus = $entrevistasStatus;
    }

    public function array(): array
    {
        // Calcular el número máximo de filas para las columnas
        $maxRows = max(
            count($this->puntosEntrega),
            count($this->entrevistadores),
            count($this->tipoDocumento),
            count($this->situacionConyugal),
            count($this->paises),
            count($this->tenencia),
            count($this->ocupacion),
            count($this->coberturaMedica),
            count($this->tipoPension),
            count($this->programaSocial),
            count($this->nivelEducativo),
            count($this->estadoEducativo),
            count($this->entrevistasStatus)
        );

        // Asegurarnos de que todas las columnas tengan el mismo número de filas, rellenando con valores vacíos si es necesario
        $puntosEntrega = array_pad($this->puntosEntrega->toArray(), $maxRows, '');
        $entrevistadores = array_pad($this->entrevistadores->toArray(), $maxRows, '');
        $tipoDocumento = array_pad($this->tipoDocumento->toArray(), $maxRows, '');
        $situacionConyugal = array_pad($this->situacionConyugal->toArray(), $maxRows, '');
        $paises = array_pad($this->paises->toArray(), $maxRows, '');
        $tenencia = array_pad($this->tenencia->toArray(), $maxRows, '');
        $ocupacion = array_pad($this->ocupacion->toArray(), $maxRows, '');
        $coberturaMedica = array_pad($this->coberturaMedica->toArray(), $maxRows, '');
        $tipoPension = array_pad($this->tipoPension->toArray(), $maxRows, '');
        $programaSocial = array_pad($this->programaSocial->toArray(), $maxRows, '');
        $nivelEducativo = array_pad($this->nivelEducativo->toArray(), $maxRows, '');
        $estadoEducativo = array_pad($this->estadoEducativo->toArray(), $maxRows, '');

        $entrevistasStatus = array_pad($this->entrevistasStatus->toArray(), $maxRows, '');
        // Organizar los datos en un arreglo para la hoja 2
        $data = [];

        $data[] = ['Sedes', '', 'Entrevistador', '', 'Estado', '', 'Tipo Documento', '', 'Situación Conyugal', '', 'Pais', '', 'Tenencia', '', 'Ocupación', '', 'Cobertura Médica', '', 'Tipo Pension', '', 'Programa Social', '', 'Nivel Educativo', '', 'Estado Educativo'];

        // Agregar las filas con los valores
        for ($i = 0; $i < $maxRows; $i++) {
            $data[] = [
                $puntosEntrega[$i],
                '',
                $entrevistadores[$i],
                '',
                $entrevistasStatus[$i],
                '',
                $tipoDocumento[$i],
                '',
                $situacionConyugal[$i],
                '',
                $paises[$i],
                '',
                $tenencia[$i],
                '',
                $ocupacion[$i],
                '',
                $coberturaMedica[$i],
                '',
                $tipoPension[$i],
                '',
                $programaSocial[$i],
                '',
                $nivelEducativo[$i],
                '',
                $estadoEducativo[$i]
            ];
        }

        return $data;
    }
    // Método para autoajustar las columnas al contenido
    public function autoSize(): array
    {
        return [
            'A',
            'B',
            'C',
            'D',
            'E',
            'F',
            'G',
            'H',
            'I',
            'J',
            'K',
            'L',
            'M',
            'N',
            'O',
            'P',
            'Q',
            'R',
            'S',
            'T' // Ajustar el tamaño de las columnas A-G
        ];
    }

    // Método para aplicar estilos a las celdas
    public function styles(Worksheet $sheet)
    {
        // Estilo para la primera fila (celdas de título)
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
        ];
    }

}

