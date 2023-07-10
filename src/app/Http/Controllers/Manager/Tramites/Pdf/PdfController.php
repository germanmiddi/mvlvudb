<?php

namespace App\Http\Controllers\Manager\Tramites\Pdf;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Carbon;

// Models
use App\Models\Manager\Tramite;

class PdfController extends Controller
{
    public function acusePdf(Tramite $tramite){
        $data = [
            'num_tramite' => $tramite->id,
            'fecha' => Carbon::parse($tramite->fecha)->format("d-m-Y"),
            'titular' => $tramite->persons[0]->lastname.', '.$tramite->persons[0]->name,
            'domicilio' => $tramite->persons[0]->address[0]->google_address,
            'num_documento' => $tramite->persons[0]->num_documento,
            'dependencia' => $tramite->tipoTramite->dependencia->description,
            'tipo_tramite' => $tramite->tipoTramite->description,
            'observacion' => $tramite->observacion
        ];
        return PDF::loadView('pdf/acusepdf', $data)->stream('acuse.pdf');
    }
}
