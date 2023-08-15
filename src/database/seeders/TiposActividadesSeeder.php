<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TiposActividadesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['id' => 1, 'description' => 'Deportivas'],
            ['id' => 2, 'description' => 'Culturales'],
            ['id' => 3, 'description' => 'Recreativas'],
            ['id' => 4, 'description' => 'Sociales'],
            ['id' => 5, 'description' => 'Salud/Nutrición'],
            ['id' => 6, 'description' => 'Apoyo Escolar'],
            ['id' => 7, 'description' => 'Talleres de Inclusión'],
        ];

        DB::table('tipos_actividades')->insert($data);
    }
}
