<?php

namespace App\Http\Controllers\Manager\Logs;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;

class LogController extends Controller
{
    public function index(){

        return Inertia::render('Manager/Logs/Index');

    }

    public function listLast()
    {
        $length = request('length');
        $logFile = storage_path('logs/laravel.log');
        $logs = '';
        if (file_exists($logFile)) {
            $logs = array_slice(file($logFile), -$length);
            
    
            // Convertir las líneas del log en un array con saltos de línea convertidos a <br>
        $logs = array_map(function ($log) {
            return nl2br($log);
        }, $logs);

        // Invertir el orden de los registros para mostrarlos en orden descendente
        $logs = array_reverse($logs);
            return response()->json(['message' => 'Se ha procesado el registro de logs.', 'data' => $logs], 200);
        }
        return response()->json(['message' => 'Se ha producido un error. Comuniquese con el administrador.'], 203);
    }
}