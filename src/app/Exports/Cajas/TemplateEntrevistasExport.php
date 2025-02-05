<?php

namespace App\Exports\Cajas;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

use App\Exports\Cajas\TemplateEntrevistasHeaderExport;
use App\Exports\Cajas\TemplateEntrevistasDatosReferenciaExport;

class TemplateEntrevistasExport implements WithMultipleSheets
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
    public function __construct($puntosEntrega, $entrevistadores, $tipoDocumento, $situacionConyugal, $paises, $tenencia, $ocupacion, $coberturaMedica, $tipoPension, $programaSocial, $nivelEducativo, $estadoEducativo)
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
    }
    public function sheets(): array
    {
        return [
            new TemplateEntrevistasHeaderExport(),
            new TemplateEntrevistasDatosReferenciaExport(
                $this->puntosEntrega,
                $this->entrevistadores,
                $this->tipoDocumento,
                $this->situacionConyugal,
                $this->paises,
                $this->tenencia,
                $this->ocupacion,
                $this->coberturaMedica,
                $this->tipoPension,
                $this->programaSocial,
                $this->nivelEducativo,
                $this->estadoEducativo
            ),
        ];
    }
}

