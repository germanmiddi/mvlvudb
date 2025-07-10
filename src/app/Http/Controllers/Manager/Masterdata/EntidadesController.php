<?php

namespace App\Http\Controllers\Manager\Masterdata;

use App\Http\Controllers\Controller;
use App\Models\Manager\EntidadRol;
use Illuminate\Http\Request;

class EntidadesController extends Controller
{
    /**
     * Obtener todos los roles de entidad
     */
    public function get_entidad_roles()
    {
        try {
            $roles = EntidadRol::orderBy('name', 'asc')->get();
            return response()->json($roles);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al obtener los roles'], 500);
        }
    }

    /**
     * Crear un nuevo rol de entidad
     */
    public function store_entidad_roles(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255|unique:entidad_rols,name',
                'description' => 'nullable|string|max:255'
            ]);

            $rol = EntidadRol::create([
                'name' => $request->name,
                'description' => $request->description
            ]);

            return response()->json([
                'message' => 'Rol creado exitosamente',
                'rol' => $rol
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al crear el rol: ' . $e->getMessage()
            ], 400);
        }
    }

    /**
     * Actualizar un rol de entidad existente
     */
    public function update_entidad_roles(Request $request)
    {
        try {
            $request->validate([
                'id' => 'required|exists:entidad_rols,id',
                'name' => 'required|string|max:255|unique:entidad_rols,name,' . $request->id,
                'description' => 'nullable|string|max:255'
            ]);

            $rol = EntidadRol::findOrFail($request->id);
            $rol->update([
                'name' => $request->name,
                'description' => $request->description
            ]);

            return response()->json([
                'message' => 'Rol actualizado exitosamente',
                'rol' => $rol
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al actualizar el rol: ' . $e->getMessage()
            ], 400);
        }
    }

    /**
     * Ocultar un rol de entidad (soft delete simulado)
     * Como no hay campo 'activo', implementamos como eliminación suave
     */
    public function hide_entidad_roles(Request $request)
    {
        try {
            $request->validate([
                'id' => 'required|exists:entidad_rols,id'
            ]);

            $rol = EntidadRol::findOrFail($request->id);

            // Como no hay campo activo, podrías agregar uno o usar soft deletes
            // Por ahora simularemos ocultándolo agregando un prefijo
            $rol->update([
                'name' => '[INACTIVO] ' . $rol->name
            ]);

            return response()->json([
                'message' => 'Rol ocultado exitosamente'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al ocultar el rol: ' . $e->getMessage()
            ], 400);
        }
    }

    /**
     * Eliminar permanentemente un rol de entidad
     */
    public function destroy_entidad_roles(Request $request)
    {
        try {
            $request->validate([
                'id' => 'required|exists:entidad_rols,id'
            ]);

            $rol = EntidadRol::findOrFail($request->id);

            // Verificar si el rol está siendo usado en alguna relación
            // Aquí puedes agregar validaciones si hay tablas relacionadas

            $rol->delete();

            return response()->json([
                'message' => 'Rol eliminado exitosamente'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al eliminar el rol: ' . $e->getMessage()
            ], 400);
        }
    }
}
