<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LocalidadesCoordsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Coordenadas de las localidades de Vicente López
        $coordenadasLocalidades = [
            'CARAPACHAY' => ['lat' => -34.5269, 'lng' => -58.5106],
            'FLORIDA' => ['lat' => -34.5321, 'lng' => -58.4895],
            'FLORIDA OESTE' => ['lat' => -34.5356, 'lng' => -58.4985],
            'LA LUCILA' => ['lat' => -34.5025, 'lng' => -58.4756],
            'MUNRO' => ['lat' => -34.5469, 'lng' => -58.5298],
            'OLIVOS' => ['lat' => -34.5167, 'lng' => -58.4833],
            'VILLA MARTELLI' => ['lat' => -34.5389, 'lng' => -58.5056],
            'VICENTE LOPEZ' => ['lat' => -34.5243, 'lng' => -58.4784],
            'VILLA ADELINA' => ['lat' => -34.5098, 'lng' => -58.4923]
        ];

        $this->command->info('Iniciando actualización de coordenadas de localidades...');

        $actualizadas = 0;
        $noEncontradas = 0;

        foreach ($coordenadasLocalidades as $nombreLocalidad => $coordenadas) {
            // Buscar la localidad por nombre (insensible a mayúsculas/minúsculas)
            $localidad = DB::table('localidades')
                ->whereRaw('UPPER(description) = ?', [strtoupper($nombreLocalidad)])
                ->first();

            if ($localidad) {
                // Actualizar coordenadas
                DB::table('localidades')
                    ->where('id', $localidad->id)
                    ->update([
                        'latitud' => $coordenadas['lat'],
                        'longitud' => $coordenadas['lng'],
                        'updated_at' => now()
                    ]);

                $this->command->info("✓ Actualizada: {$nombreLocalidad} (ID: {$localidad->id})");
                $actualizadas++;
            } else {
                $this->command->warn("✗ No encontrada: {$nombreLocalidad}");
                $noEncontradas++;
            }
        }

        $this->command->info("Proceso completado:");
        $this->command->info("- Localidades actualizadas: {$actualizadas}");
        $this->command->info("- Localidades no encontradas: {$noEncontradas}");

        if ($noEncontradas > 0) {
            $this->command->warn("Las localidades no encontradas deberán completarse manualmente.");
        }
    }
}
