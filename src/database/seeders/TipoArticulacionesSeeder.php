<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TipoArticulacionesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['id' => 1, 'description' => 'Niñez'],
            ['id' => 2, 'description' => 'Educación'],
            ['id' => 3, 'description' => 'Salud'],
            ['id' => 4, 'description' => 'Genero'],
            ['id' => 5, 'description' => 'Discapacidad'],
            ['id' => 6, 'description' => 'Fortalecimiento Comunitario'],
            ['id' => 7, 'description' => 'Habitat'],
        ];

        DB::table('tipo_articulaciones')->insert($data);
    }
}
