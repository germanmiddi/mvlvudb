<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EstadosSaludSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['id' => 1, 'description' => 'Celiaquía'],
            ['id' => 2, 'description' => 'Diabetes'],
            ['id' => 3, 'description' => 'Alergia'],
            ['id' => 4, 'description' => 'Problemas nutricionales'],
            ['id' => 5, 'description' => 'CUD'],
            ['id' => 6, 'description' => 'En tratamiento psicológico'],
            ['id' => 7, 'description' => 'En tratamiento psicopedagógico'],
            ['id' => 8, 'description' => 'En tratamiento fonoaudiológico'],
            ['id' => 9, 'description' => 'En tratamiento psiquiátrico'],
            ['id' => 10, 'description' => 'Ninguna'],
            ['id' => 11, 'description' => 'Ns/Nc'],
            ['id' => 12, 'description' => 'Otros'],
        ];

        DB::table('estados_salud')->insert($data);
    }
}
