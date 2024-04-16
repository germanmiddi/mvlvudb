<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TipoDerivacionesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['id' => 1, 'description' => 'Salud'],
            ['id' => 2, 'description' => 'Servicio Local'],
            ['id' => 3, 'description' => 'ASI'],
            ['id' => 4, 'description' => 'Violencia Intrafamiliar'],
            ['id' => 5, 'description' => 'Negligencia'],
            ['id' => 6, 'description' => 'Deserción Escolar'],
            ['id' => 7, 'description' => 'Consumo Problematico'],
        ];

        DB::table('tipo_derivaciones')->insert($data);
    }
}
