<?php

namespace App\Http\Controllers\Manager\Uploads;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Carbon\Carbon;



use App\Http\Controllers\Controller;
use App\Models\Manager\Archivo;
use Illuminate\Http\Request;

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
        } catch (\Throwable $th) {
            dd($th);
        }
    }

    public function downloadfile($id)
    {

        $archivo = Archivo::where('id', $id)->first();

        // Verificar si el archivo existe
        if (!Storage::disk('public')->exists($archivo['name'])) {
            abort(404);
        }
        // Generar la respuesta de descarga
        return response()->download(storage_path('app/public/' . $archivo['name']));
    }
}
