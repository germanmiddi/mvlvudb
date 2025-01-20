<?php

namespace App\Services;

use App\Models\Manager\CajasEntrevistasStatus;
use App\Models\Manager\CanalAtencion;
use App\Models\Manager\Dependencia;
use App\Models\Manager\TipoTramite;
use App\Models\Manager\Tramite;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class CajasServices
{
    public function createTramite($entrevista)
    {
        // Usar variables para las descripciones que no cambian, para evitar consultas repetidas
        $canalAtencion = CanalAtencion::where('description', 'SEC. DESARROLLO SOCIAL - SEDE YRIGOYEN')->first();
        $dependencia = Dependencia::where('description', 'FORTALECIMIENTO COMUNITARIO')->first();
        $tipoTramite = TipoTramite::where('description', 'EMPADRONAMIENTO CAJAS')->first();

        // Validar que las entidades existan para evitar errores
        if (!$canalAtencion || !$dependencia || !$tipoTramite) {
            Log::error('Datos no encontrados para la creación del trámite', [
                "Usuario" => Auth::user()->id . ": " . Auth::user()->name,
                "CanalAtencion" => $canalAtencion ? $canalAtencion->id : null,
                "Dependencia" => $dependencia ? $dependencia->id : null,
                "TipoTramite" => $tipoTramite ? $tipoTramite->id : null
            ]);
            return response()->json(['message' => 'Datos requeridos no encontrados.'], 404);
        }

        // Crear el tramite utilizando la data ya obtenida
        try {
            $tramiteData = Tramite::create([
                'fecha' => $entrevista->fecha,
                'canal_atencion_id' => $canalAtencion->id,
                'tipo_tramite_id' => $tipoTramite->id,
                'dependencia_id' => $dependencia->id,
                'estado_id' => 1, // Estado Abierto
            ]);

            // Asociar el tramite a la persona
            $entrevista->person->tramites()->attach($tramiteData->id, ['rol_tramite_id' => 1]); // ROL TITULAR

            // Log de éxito
            Log::info("Se ha creado un nuevo tramite", [
                "Modulo" => "Entrevistas:createTramite",
                "Usuario" => Auth::user()->id . ": " . Auth::user()->name,
                "ID Tramite" => $tramiteData->id
            ]);

            return response()->json(['message' => 'Trámite creado exitosamente.'], 200);
        } catch (\Exception $e) {
            // Manejo de errores más claro
            Log::error('Error al crear el tramite', [
                "Usuario" => Auth::user()->id . ": " . Auth::user()->name,
                "Error" => $e->getMessage()
            ]);

            return response()->json(['message' => 'Error al crear el trámite.'], 500);
        }
    }


}