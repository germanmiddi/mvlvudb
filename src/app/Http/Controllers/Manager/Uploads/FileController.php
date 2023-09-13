<?php

namespace App\Http\Controllers\Manager\Uploads;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Carbon\Carbon;



use App\Http\Controllers\Controller;
use App\Models\Manager\Archivo;
use App\Models\Manager\Tramite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class FileController extends Controller
{
    public function upload($data)
    {
        try {
            $extension = $data['file']->getClientOriginalExtension();
            $fileName = $data['dependencia'].'-ID'.$data['tramite_id'].'-'.Carbon::now().'.'.$extension; // Generar un nuevo nombre para el archivo
            Storage::putFileAs('public', $data['file'], $fileName);
    
            Archivo::Create(
                [
                    'name' => $fileName,
                    'description' => $data['description'],
                    'ext' => $extension,
                    'tramite_id' => $data['tramite_id']
                ]
            );
            Log::info("Se ha almacenado un FILE ", ["Modulo" => "File:upload","Usuario" => Auth::user()->id.": ".Auth::user()->name, "ID Tramite" => $data['tramite_id'], "Nombre File" => $fileName ]);
        } catch (\Throwable $th) {
            Log::error("Se ha generado un error al momento de almacenar el FILE", ["Modulo" => "File:upload","Usuario" => Auth::user()->id.": ".Auth::user()->name, "Error" => $th->getMessage() ]);
        }
    }

    public function uploadFile(Request $request)
    {
        try {
            if ($request->hasFile('file')) {
                $extension = $request['file']->getClientOriginalExtension();

                $tramite = Tramite::where('id', $request['tramite_id'])->first();
                $fileName = $tramite->dependencia['description'].'-ID'.$request['tramite_id'].'-'.Carbon::now()->timestamp.'.'.$extension; // Generar un nuevo nombre para el archivo
                Storage::putFileAs('public', $request['file'], $fileName);
        
                $archivo = Archivo::Create(
                    [
                        'name' => $fileName,
                        'description' => $request['description'],
                        'ext' => $extension,
                        'tramite_id' => $request['tramite_id']
                    ]
                );
                Log::info("Se ha almacenado un FILE ", ["Modulo" => "File:uploadFile","Usuario" => Auth::user()->id.": ".Auth::user()->name, "ID Tramite" => $request['tramite_id'], "Nombre File" => $fileName ]);
                return response()->json(['message' => 'Se ha recibido un Archivo. Comuniquese con el administrador.', 'archivo' => $archivo], 200);
            }else{

                Log::info("Se ha recibido un FILE ", ["Modulo" => "File:uploadFile","Usuario" => Auth::user()->id.": ".Auth::user()->name, "ID Tramite" => $request['tramite_id']]);
                return response()->json(['message' => 'Se ha recibido un Archivo. Comuniquese con el administrador.'], 203);
            }
        } catch (\Throwable $th) {
            //dd($th);
            Log::error("Se ha generado un error al momento de almacenar el FILE", ["Modulo" => "File:uploadFile","Usuario" => Auth::user()->id.": ".Auth::user()->name, "Error" => $th->getMessage() ]);
            return response()->json(['message' => 'Se ha generado un error al momento de almacenar el Archivo. Comuniquese con el administrador.'], 203);
        }
    }

    public function uploadbase64($data)
    {
        /*
        ** Funcion que recibe un archivo base64.
        */
        //dd($data);
        try {

            $image_service_str = substr($data['base64'], strpos($data['base64'], ",")+1);
            // Se decodifica el string y devuelve los datos de la imagen        
            $image = base64_decode($image_service_str);

            /* Se obtiene la extension del archivo en la variable $extension[]
            **  0 => "data:image/jpeg;base64"
            **  1 => "jpeg"
            */

            preg_match("/^data:(image\/[a-z]+|application\/pdf);base64/i",$data['base64'], $extension); 
            //preg_match("/^data:image\/(.*);base64/i",$data['base64'], $extension); 
            // preg_match("/^data:image\/(.*);base64/i", $data['base64'], $extensionMatches);
            if (!isset($extension[1])) {

                    $dataUri = $data['base64'];

                    // Obtener el tipo de contenido y la extensión
                    list($contentType, $base64Data) = explode(',', $dataUri, 2);

                    if (strpos($contentType, 'image/') === 0) {
                        $extension[1] = str_replace('image/', '', $contentType);
                    } elseif (strpos($contentType, 'application/pdf') === 0) {
                        $extension[1] = str_replace('application/pdf', '', $contentType);
                    }else{
                        throw new \Exception("El Formato de archivo no es un formato valido");
                    }


            }

            //$extension = $data['file']->getClientOriginalExtension();
            $fileName = $data['dependencia'].'-ID'.$data['tramite_id'].'-'.Carbon::now().''.Str::random(5).'.'.$extension[1]; // Generar un nuevo nombre para el archivo
            Storage::disk('public')->put($fileName, $image);
            //Storage::putFileAs('public', $image, $fileName);
    
            Archivo::Create(
                [
                    'name' => $fileName,
                    'description' => $data['description'],
                    'ext' => $extension[1],
                    'tramite_id' => $data['tramite_id']
                ]
            );
            Log::info("Se ha almacenado un FILE ", ["Modulo" => "File:upload","Usuario" => Auth::user()->id.": ".Auth::user()->name, "ID Tramite" => $data['tramite_id'], "Nombre File" => $fileName ]);
        } catch (\Throwable $th) {
            //dd($th);
            Log::error("Se ha generado un error al momento de almacenar el FILE", ["Modulo" => "File:upload","Usuario" => Auth::user()->id.": ".Auth::user()->name, "Error" => $th->getMessage() ]);
        }
    }

    public function downloadfile($id)
    {

        $archivo = Archivo::where('id', $id)->first();

        // Verificar si el archivo existe
        if (!Storage::disk('public')->exists($archivo['name'])) {
            Log::error("Se ha generado un error al momento de descargar el FILE", ["Modulo" => "File:upload","Usuario" => Auth::user()->id.": ".Auth::user()->name, "Error" => 'File no existente' ]);
            abort(404);
        }
        // Generar la respuesta de descarga
        Log::info("Se ha realizado la descarga de un FILE ", ["Modulo" => "File:downloadfile","Usuario" => Auth::user()->id.": ".Auth::user()->name, "Nombre File" => $archivo['name'] ]);
        return response()->download(storage_path('app/public/' . $archivo['name']));
    }

    public function deletefile($id){

        try {
        $file = Archivo::where('id', $id)->first();
            if (Storage::disk('public')->exists($file->name)) {
                Archivo::where('id', $id)->delete();
                Storage::disk('public')->delete($file->name);
                Log::info("Se ha eliminado un FILE ", ["Modulo" => "File:delete","Usuario" => Auth::user()->id.": ".Auth::user()->name, "ID Archivo" => $id, "Nombre File" => $file->name ]);
                return response()->json(['message' => 'Se eliminado correctamente el archivo.'], 200);
            } else {
                Log::info("No se ha encontrado el FILE ", ["Modulo" => "File:delete","Usuario" => Auth::user()->id.": ".Auth::user()->name, "ID Archivo" => $id, "Nombre File" => $file->name ]);
                return response()->json(['message' => 'Se ha encontrado el archivo que desea eliminar. Comuniquese con el administrador.'], 203);
            }
        } catch (\Throwable $th) {
            Log::error("Se ha generado un error al momento de eliminar el FILE", ["Modulo" => "File:delete","Usuario" => Auth::user()->id.": ".Auth::user()->name, 'ID ARCHIVO' => $id, "Error" => $th->getMessage() ]);
            return response()->json(['message' => 'Se ha producido un error al momento de intentar eliminar el archivo. Comuniquese con el administrador.'], 203);
        }
    }
}
