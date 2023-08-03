<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EscuelasOrientacionesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['id' => 1, 'description' => 'Industrial'],
            ['id' => 2, 'description' => 'Ciencias Sociales'],
            ['id' => 3, 'description' => 'Ciencias Naturales'],
            ['id' => 4, 'description' => 'Economia y Administración'],
            ['id' => 5, 'description' => 'Comunicacion'],
            ['id' => 6, 'description' => 'Arte'],
            ['id' => 7, 'description' => 'Educación Fisica'],
            ['id' => 8, 'description' => 'Lenguas Extranjeras'],
            ['id' => 9, 'description' => 'Fisico Matemática'],
            ['id' => 10, 'description' => 'Literatura'],
            ['id' => 11, 'description' => 'Otro'],
        ];

        DB::table('orientaciones_escuela')->insert($data);
    }
}
