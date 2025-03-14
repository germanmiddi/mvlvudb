<?php

namespace App\Http\Controllers\Manager\Tramites\Pdf;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Manager\Tramites\General\GeneralController;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Carbon;

// Models
use App\Models\Manager\Tramite;
use Illuminate\Support\Facades\Auth;

class PdfController extends Controller
{
    public function acusepdf(Tramite $tramite)
    {
        $data = [
            'num_tramite' => $tramite->id,
            'fecha' => Carbon::parse($tramite->fecha)->format("d-m-Y"),
            'titular' => $tramite->persons[0]->lastname . ', ' . $tramite->persons[0]->name,
            'domicilio' => $tramite->persons[0]->address[0]->google_address,
            'num_documento' => $tramite->persons[0]->num_documento,
            'dependencia' => $tramite->tipoTramite->dependencia->description,
            'modalidad_atencion' => isset($tramite->modalidadAtencion->description) ? $tramite->modalidadAtencion->description : '-',
            'phone' => $tramite->persons[0]->contact[0]->phone,
            'celular' => $tramite->persons[0]->contact[0]->celular,
            'tipo_tramite' => $tramite->tipoTramite->description,
            'observacion' => $tramite->observacion,
            'cud_codigo' => $tramite->persons[0]->cud ? $tramite->persons[0]->cud->codigo : null,
            'cud_diagnostico' => $tramite->persons[0]->cud ? $tramite->persons[0]->cud->diagnostico : null,
        ];
        return PDF::loadView('pdf/acusePdf', $data)->stream('acuse.pdf');
    }

    public function acuseObservacionPdf(Tramite $tramite)
    {
        $generalController = new GeneralController();
        if ($generalController->_check_permission($tramite->dependencia['rol_prefix']) || $generalController->_check_permission('ALL')) {
            $data = [
                'num_tramite' => $tramite->id,
                'fecha' => Carbon::parse($tramite->fecha)->format("d-m-Y"),
                'titular' => $tramite->persons[0]->lastname . ', ' . $tramite->persons[0]->name,
                'domicilio' => $tramite->persons[0]->address[0]->google_address,
                'num_documento' => $tramite->persons[0]->num_documento,
                'dependencia' => $tramite->tipoTramite->dependencia->description,
                'modalidad_atencion' => isset($tramite->modalidadAtencion->description) ? $tramite->modalidadAtencion->description : '-',
                'phone' => $tramite->persons[0]->contact[0]->phone,
                'celular' => $tramite->persons[0]->contact[0]->celular,
                'tipo_tramite' => $tramite->tipoTramite->description,
                'observacion' => $tramite->observacion,
                'cud_codigo' => $tramite->persons[0]->cud ? $tramite->persons[0]->cud->codigo : null,
                'cud_diagnostico' => $tramite->persons[0]->cud ? $tramite->persons[0]->cud->diagnostico : null,
                'comments' => $tramite->comments
            ];
            return PDF::loadView('pdf/acuseObservacionPdf', $data)->stream('acuseObservacion.pdf');
        } else {
            return response()->view('errors.403', [], 403);
        }
    }

}
