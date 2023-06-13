<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EstadoEducativoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['id' => 1, 'description' => 'COMPLETO'],
            ['id' => 2, 'description' => 'INCOMPLETO'],
            ['id' => 3, 'description' => 'EN CURSO'],
        ];

        DB::table('estado_educativo')->insert($data);
    }
}
