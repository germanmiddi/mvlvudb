<?php

namespace Database\Seeders;

use App\Models\Manager\Category;
use App\Models\Manager\ProgramaSocialCB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProgramasSocialesCBSeeder extends Seeder
{
    /**
     * Run the seeder.
     *
     * @return void
     */
    public function run()
    {
        $programas = [
            ['description' => 'ASIGNACIÓN UNIVERSAL POR HIJO'],
            ['description' => 'ASIGNACIÓN UNIVERSAL POR EMBARAZO'],
            ['description' => 'ASIGNACIÓN UNIVERSAL POR HIJO CON DISCAPACIDAD'],
            ['description' => 'SEGURO DE CAPACITACIÓN Y EMPLEO'],
            ['description' => 'OTROS PROGRAMAS DE EMPLEO'],
            ['description' => 'SUBSIDIOS MENSUALES PARA SALUD (PROSAR - PAMI)'],
            ['description' => 'TARJETAS, TICKETS, VALES O BONOS PARA COMPRA DE ALIMENTOS'],
            ['description' => 'TARJETA ALIMENTAR'],
            ['description' => 'ASISTENCIA ALIMENTARIA COVID 19'],
            ['description' => 'INGRESO FAMILIAR DE EMERGENCIA'],
        ];

        foreach ($programas as $programa) {
            ProgramaSocialCB::updateOrCreate(
                ['description' => $programa['description']],
                ['created_at' => now(), 'updated_at' => now()]
            );
        }
    }
}
