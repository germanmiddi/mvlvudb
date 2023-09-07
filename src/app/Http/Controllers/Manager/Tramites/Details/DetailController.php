<?php

namespace App\Http\Controllers\Manager\Tramites\Details;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Manager\Tramite;
use App\Models\Manager\TramiteEstado;
use App\Models\Manager\TramiteComment;
use App\Models\Manager\Dependencia;
use App\Models\User;

use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DetailController extends Controller
{
 
    public function view($id){

        return Inertia::render('Manager/Tramites/Detail/Details',
            [   
                'estados' => TramiteEstado::all(),
                'users' => User::all(),
                'dependencias' => Dependencia::all(),
                'tramite' => Tramite::where('id', $id)
                                    ->with('persons', 
                                           'persons.contact',
                                           'persons.address', 
                                           'persons.address.localidad',
                                           'archivos', 
                                           'tipoTramite', 
                                           'canalAtencion',
                                           'sede',
                                           'rol_tramite',
                                           'dependencia',
                                           'parentesco',
                                           'persons.cud',
                                           'cbi_data',
                                           'cbj_data',
                                           'familiares',
                                           'contactos',
                                           'persons.education',
                                           'persons.education.nivelEducativo',
                                           'persons.social',
                                           'persons.social.tipoOcupacion',
                                           'persons.social.coberturaMedica',
                                           'persons.social.tipoPension',
                                           'persons.social.programaSocial',
                                           'comments',
                                           'comments.dependencia',
                                           'comments.user',
                                           'estado',
                                           'modalidadAtencion',
                                           'category'

                                           )
                                    ->get()
            ]
        );
    }

    public function addComment(Request $request){
        DB::beginTransaction();
        try {
            // dd($request->all());
            $tramite = Tramite::find($request->tramite_id);

            $comment = new TramiteComment();
            $comment->tramite_id = $request->tramite_id;
            $comment->user_id = Auth::user()->id;
            $comment->dependencia_id = $tramite->dependencia_id;
            $comment->content = $request->observacion;
            $comment->save();

            DB::commit();
            return response()->json(['message' => 'Comentario almacenado correctamente'], 200);

        
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error("Se ha generado un error al momento de almacenar el comentario", ["Modulo" => "Comentarios:add","Usuario" => Auth::user()->id.": ".Auth::user()->name, "Error" => $th->getMessage() ]);
            return response()->json(['message' => 'Se ha producido un error almacenando el comentario'], 203);         
        }
    }

    public function getComments($tramite_id){
        try {

            $comments = TramiteComment::where('tramite_id', $tramite_id)
                        ->with(['user', 'dependencia']) 
                        ->get();
            
            return response()->json($comments, 200);
        } catch (\Throwable $th) {
            Log::error("Se ha generado un error al momento de obtener los comentarios", ["Modulo" => "Comentarios:get","Usuario" => Auth::user()->id.": ".Auth::user()->name, "Error" => $th->getMessage() ]);
            return response()->json(['message' => 'Se ha producido un error obteniendo los comentarios'], 203);         
        }
    }

    public function changeDependencia(Request $request){
        DB::beginTransaction();
        try {

            $tramite = Tramite::find($request->tramite_id);
            $old_dependencia_id = $tramite->dependencia_id;
            $tramite->dependencia_id = $request->dependencia_id;    
            $tramite->save();

            $comment = new TramiteComment();
            $comment->tramite_id = $request->tramite_id;
            $comment->user_id = Auth::user()->id;
            $comment->dependencia_id = $old_dependencia_id;
            $comment->content = $request->observacion;
            $comment->save();

            DB::commit();
            return response()->json(['message' => 'Cambio de Dependencia correctamente'], 200);

        
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error("Se ha generado un error al momento de modificar la dependencia", ["Modulo" => "Details:CambioDependencia","Usuario" => Auth::user()->id.": ".Auth::user()->name, "Error" => $th->getMessage() ]);
            return response()->json(['message' => 'Se ha producido un error'], 203);         
        }
    }

    public function changeEstado(Request $request){
        DB::beginTransaction();
        try {

            $tramite = Tramite::find($request->tramite_id);
            $tramite->estado_id = $request->estado_id;    
            $tramite->save();

            $comment = new TramiteComment();
            $comment->tramite_id = $request->tramite_id;
            $comment->user_id = Auth::user()->id;
            $comment->dependencia_id = $tramite->dependencia_id;
            
            if($request->estado_id == 1){
                $comment->content = 'Se abrio el Trámite';
            }
            else{
                $comment->content = 'Se cerro el Trámite';
            }
            
            $comment->save();

            DB::commit();
            return response()->json(['message' => 'Cambio de Estado correctamente'], 200);

        
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error("Se ha generado un error al momento de modificar el estado", ["Modulo" => "Details:CambioEstado","Usuario" => Auth::user()->id.": ".Auth::user()->name, "Error" => $th->getMessage() ]);
            return response()->json(['message' => 'Se ha producido un error'], 203);         
        }
    }

    public function changeAssigment(Request $request){
        
        DB::beginTransaction();
        try {

        
        //TODO: Confirmar si es necesario almacenar info en la tabla de tramite_assigment o con la de comentarios es suficiente
            $tramite = Tramite::find($request->tramite_id);
            $tramite->assigned = $request->user_id;
            $tramite->estado_id = 3; //En proceso    
            $tramite->save();

            $user = User::find($request->user_id);

            $comment = new TramiteComment();
            $comment->tramite_id = $request->tramite_id;
            $comment->user_id = Auth::user()->id;
            $comment->dependencia_id = $tramite->dependencia_id;
            $comment->content = 'Se asignó el trámite a: ' . $user->name . ' (' . $user->email . ')' ;
            
            $comment->save();

            DB::commit();
            return response()->json(['message' => 'Se reasignó el trámite correctamente'], 200);

        
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error("Error al reasignar el tramite", ["Modulo" => "Details:CambioAsignacion","Tramite" => $request->tramite_id, "Usuario" => Auth::user()->id.": ".Auth::user()->name, "Error" => $th->getMessage() ]);
            return response()->json(['message' => 'Se ha producido un error'], 203);         
        }
    }

    
}