<?php

namespace App\Http\Controllers\Manager\CentrosBarriales;

use App\Http\Controllers\Controller;
use Inertia\Inertia;
use Illuminate\Http\Request;

use App\Models\Manager\LegajoCB;


class LegajoController extends Controller
{
    protected $sedesAvailables = ['Munro','Villa Martelli', 'La Loma', 'El Ceibo'];


    public function index($id)
    {
        
        $legajo = LegajoCB::find($id);

        return Inertia::render('Manager/CentrosBarriales/Legajos/Index',
            [   
                'legajo' => LegajoCB::where('id',$id)
                                    ->with('estadocbj', 
                                           'sede', 
                                           'responsable', 
                                           'person', 
                                           'person.contact', 
                                           'autorizacion', 
                                           'canal_atencion',
                                           'person.address', 
                                           'person.address.localidad',
                                           'person.address.barrio',
                                           'person.salud',
                                           'person.cud',
                                           'person.education',
                                           'person.education.nivelEducativo', 
                                           'person.education.estadoEducativo',
                                           'person.education.escuelaTurno',
                                           'tipo_legajo')->get(),                
            ]
        );        
        
        // return Inertia::render('',
        //     [
        //         'localidades' => Localidad::all(),
        //         'canalesAtencion' => CanalAtencion::where('id','<>',10)->get(),
        //         'tiposDocumento' => TipoDocumento::all(),
        //         'tiposTramite' => TipoTramite::where('dependencia_id', 13)->active()->get(),
        //         'sedes' => Sede::whereIn('description', $this->sedesAvailables)->get(),
        //         'comedores' => Comedor::where('activo', true)->get(),
        //         'actividadesCbj' => ActividadCbj::where('activo', true)->get(),
        //         'acompanamientosCbj' => AcompanamientoCbj::where('activo', true)->get(),
        //         'nivelesEducativo' => NivelEducativo::all(),
        //         'estadosEducativo' => EstadoEducativo::all(),
        //         'turnosEducativo' => EscuelaTurno::all(),
        //     ]
        // );
    }
}