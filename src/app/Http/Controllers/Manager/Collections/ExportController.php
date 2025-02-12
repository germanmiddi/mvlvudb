<?php

namespace App\Http\Controllers\Manager\Collections;

use App\Http\Controllers\Controller;
use App\Models\Manager\Entrevista;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\Cajas\TemplateEntrevistasExport;

use App\Models\Manager\PuntoEntrega;
use App\Models\User;
use App\Models\Manager\TipoDocumento;
use App\Models\Manager\SituacionConyugal;
use App\Models\Manager\Pais;
use App\Models\Manager\TipoTenencia;
use App\Models\Manager\TipoOcupacion;
use App\Models\Manager\CoberturaMedica;
use App\Models\Manager\TipoPension;
use App\Models\Manager\ProgramaSocial;
use App\Models\Manager\NivelEducativo;
use App\Models\Manager\EstadoEducativo;
use App\Models\Manager\CajasEntrevistasStatus;

class ExportController extends Controller
{
    public function exportTemplateEntrevistas()
    {

        // SEDE_ID
        $puntosEntrega = PuntoEntrega::all()->map(function ($puntoEntrega) {
            return $puntoEntrega->id . '. ' . $puntoEntrega->description;
        });

        // ENTREVISTADOR
        $entrevistadores = User::whereHas('puntosEntrega')->get()->map(function ($entrevistador) {
            return $entrevistador->id . '. ' . $entrevistador->name;
        });

        // Tipo_Documento
        $tipoDocumento = TipoDocumento::all()->map(function ($tipoDocumento) {
            return $tipoDocumento->id . '. ' . $tipoDocumento->description;
        });


        // situacion_conyugal
        $situacionConyugal = SituacionConyugal::all()->map(function ($situacionConyugal) {
            return $situacionConyugal->id . '. ' . $situacionConyugal->description;
        });
        // Paises
        $paises = Pais::all()->map(function ($pais) {
            return $pais->id . '. ' . $pais->description;
        });

        // TENENCIA
        $tenencia = TipoTenencia::all()->map(function ($tenencia) {
            return $tenencia->id . '. ' . $tenencia->descripcion;
        });
        // ocupacion
        $ocupacion = TipoOcupacion::all()->map(function ($ocupacion) {
            return $ocupacion->id . '. ' . $ocupacion->description;
        });
        // cobertura_salud
        $coberturaMedica = CoberturaMedica::all()->map(function ($coberturaMedica) {
            return $coberturaMedica->id . '. ' . $coberturaMedica->description;
        });

        // pensiones
        $tipoPension = TipoPension::all()->map(function ($tipoPension) {
            return $tipoPension->id . '. ' . $tipoPension->description;
        });

        // SOCIAL PROGRAMA 
        $programaSocial = ProgramaSocial::all()->map(function ($programaSocial) {
            return $programaSocial->id . '. ' . $programaSocial->description;
        });

        // nivel_ed_curso
        $nivelEducativo = NivelEducativo::all()->map(function ($nivelEducativo) {
            return $nivelEducativo->id . '. ' . $nivelEducativo->description;
        });


        // nivel_alcanzado
        $estadoEducativo = EstadoEducativo::all()->map(function ($estadoEducativo) {
            return $estadoEducativo->id . '. ' . $estadoEducativo->description;
        });


        $entrevistasStatus = CajasEntrevistasStatus::all()->map(function ($status) {
            return $status->id . '. ' . $status->nombre;
        });

        return Excel::download(
            new TemplateEntrevistasExport(
                $puntosEntrega,
                $entrevistadores,
                $tipoDocumento,
                $situacionConyugal,
                $paises,
                $tenencia,
                $ocupacion,
                $coberturaMedica,
                $tipoPension,
                $programaSocial,
                $nivelEducativo,
                $estadoEducativo,
                $entrevistasStatus
            ),
            'template_entrevistas.xlsx'
        );
    }
}
