<?php

namespace App\Http\Controllers\Manager\Collections;

use App\Http\Controllers\Controller;
use App\Models\Manager\Entrevista;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\Cajas\TemplateEntrevistasExport;
use App\Exports\Cajas\TemplateEntrevistasExport2;

use App\Models\Manager\PuntoEntrega;
use App\Models\Manager\SituacionConyugal;
use App\Models\User;
use App\Models\Manager\Pais;
use App\Models\Manager\TipoDocumento;

class ExportController extends Controller
{
    public function exportTemplateEntrevistas()
    {

        return Excel::download(new TemplateEntrevistasExport(), 'template_entrevistas.xlsx');
    }

    public function exportTemplateEntrevistas2()
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
        // ocupacion
        // cobertura_salud
        // pensiones
        // SOCIAL PROGRAMA 
        // nivel_ed_curso
        // nivel_alcanzado



        return Excel::download(
            new TemplateEntrevistasExport2(
                $puntosEntrega,
                $entrevistadores,
                $tipoDocumento,
                $situacionConyugal
            ),
            'template_entrevistas.xlsx'
        );
    }
}
