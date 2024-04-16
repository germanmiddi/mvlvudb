<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MotivoBajasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['id' => 1, 'description' => 'Falta de Adherencia'],
            ['id' => 2, 'description' => 'Migracion'],
            ['id' => 3, 'description' => 'Cambio de horario en la Escolaridad'],
        ];

        DB::table('motivo_bajas')->insert($data);
    }
}
