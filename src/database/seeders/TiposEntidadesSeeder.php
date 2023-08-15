<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TiposEntidadesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['id' => 1, 'description' => 'Clubes, Sociedades de Fomento y Mutuales'],
            ['id' => 2, 'description' => 'Centros de Jubilados'],
            ['id' => 3, 'description' => 'Discapacidad'],
            ['id' => 4, 'description' => 'Scouts'],
            ['id' => 5, 'description' => 'Culto y Colectividades'],
            ['id' => 6, 'description' => 'Totarys y Leones'],
            ['id' => 7, 'description' => 'Salud'],
            ['id' => 8, 'description' => 'Entidades en Gral'],
        ];

        DB::table('tipos_entidades')->insert($data);
    }
}
