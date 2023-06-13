<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CoberturaMedicaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['id' => 1, 'description' => 'OBRA SOCIAL'],
            ['id' => 2, 'description' => 'MUTUAL/PREPAGA'],
            ['id' => 3, 'description' => 'PLAN NACER/PLAN SUMAR'],
            ['id' => 4, 'description' => 'INCLUIR SALUD (EX PROFE)'],
            ['id' => 5, 'description' => 'SERVICIO DE EMERGENCIA'],
            ['id' => 6, 'description' => 'PAMI'],
            ['id' => 7, 'description' => 'NINGUNA'],
            ['id' => 99, 'description' => 'NS/NC'],
        ];

        DB::table('cobertura_medica')->insert($data);
    }
}
