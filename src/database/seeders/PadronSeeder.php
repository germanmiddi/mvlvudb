<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Padron;

class PadronSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Crear padrón por defecto para datos existentes
        Padron::create([
            'nombre' => '2024 - Padrón Inicial',
            'descripcion' => 'Padrón inicial para entrevistas existentes antes de la implementación del sistema de padrones',
            'activo' => true,
            'fecha_inicio' => '2024-01-01',
            'fecha_fin' => null
        ]);

        // Crear algunos padrones de ejemplo
        Padron::create([
            'nombre' => '2025 - Entrega Regular',
            'descripcion' => 'Padrón 2025 para entrega regular de cajas de alimentos',
            'activo' => true,
            'fecha_inicio' => '2025-01-01',
            'fecha_fin' => '2025-12-31'
        ]);

        Padron::create([
            'nombre' => '2025 - Re categorización',
            'descripcion' => 'Padrón 2025 para re categorización de beneficiarios',
            'activo' => true,
            'fecha_inicio' => '2025-06-01',
            'fecha_fin' => '2025-12-31'
        ]);
    }
}
