<?php

namespace App\Http\Controllers\Manager\Tramites\Entidad;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Exports\Entidades\TemplateEntidadParticipanteExport;
use Maatwebsite\Excel\Facades\Excel;

class EntidadParticipanteController extends Controller
{
    public function exportTemplateEntidadParticipante(){
        return Excel::download(new TemplateEntidadParticipanteExport(), 'template_entidad_participante.xlsx');
    }
}
