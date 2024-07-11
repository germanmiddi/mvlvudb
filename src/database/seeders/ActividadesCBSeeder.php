<?php

namespace Database\Seeders;

use App\Models\Manager\ActividadCB;
use App\Models\Manager\Category;
use App\Models\Manager\ProgramaSocialCB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ActividadesCBSeeder extends Seeder
{
    /**
     * Run the seeder.
     *
     * @return void
     */
    public function run()
    {
        $programas = [
            ['description' => 'Ajedrez'],
            ['description' => 'Arte'],
            ['description' => 'Huerta'],
            ['description' => 'Ensamble musical'],
            ['description' => 'Indumentaria'],
            ['description' => 'Futbol'],
            ['description' => 'Percusion '],
            ['description' => 'Tecnologia'],
            ['description' => 'Artesanias'],
            ['description' => 'Carpinteria'],
            ['description' => 'Manicuria'],
            ['description' => 'Programacion'],
            ['description' => 'Panaderia'],
            ['description' => 'Coreografia'],
            ['description' => 'Cocina'],
            ['description' => 'Barberia'],
            ['description' => 'Karate'],
            ['description' => 'Ping Pong'],
            ['description' => 'Musica'],
            ['description' => 'Reparacion de PC'],
            ['description' => 'Otro'],
            
        ];

        foreach ($programas as $programa) {
            ActividadCB::updateOrCreate(
                ['description' => $programa['description']],
                ['created_at' => now(), 'updated_at' => now()]
            );
        }
    }
}
