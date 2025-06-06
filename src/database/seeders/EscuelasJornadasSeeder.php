<?php

namespace Database\Seeders;

use App\Models\Manager\EscuelaJornada;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EscuelasJornadasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['id' => 1, 'description' => 'JORNADA SIMPLE', 'activo' => 1],
            ['id' => 2, 'description' => 'JORNADA COMPLETA', 'activo' => 1],
            ['id' => 3, 'description' => 'JORNADA SIMPLE/COMPLETA', 'activo' => 1],
            ['id' => 4, 'description' => 'TERMINALIDAD EDUCATIVA ON LINE', 'activo' => 1],
        ];

        foreach ($data as $item) {
            EscuelaJornada::updateOrCreate(
                ['id' => $item['id']],
                [
                    'description' => $item['description'],
                    'activo' => $item['activo']
                ]
            );
        }
    }
}
