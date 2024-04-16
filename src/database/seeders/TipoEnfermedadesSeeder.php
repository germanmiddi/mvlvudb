<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TipoEnfermedadesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['id' => 1, 'description' => 'No'],
            ['id' => 2, 'description' => 'Si, con tratamiento'],
            ['id' => 3, 'description' => 'Si, sin tratamiento']
        ];

        DB::table('tipo_enfermedades')->insert($data);
    }
}
