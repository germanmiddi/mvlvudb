<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DependenciasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['id' => 2, 'description' => 'DISCAPACIDAD', 'activo' => true],
            ['id' => 3, 'description' => 'ENTIDADES INTERMEDIAS', 'activo' => true],
            ['id' => 4, 'description' => 'TARJETA ALIMENTARIA', 'activo' => true],
            ['id' => 5, 'description' => 'FORTALECIMIENTO COMUNITARIO', 'activo' => true],
            ['id' => 6, 'description' => 'GÉNERO Y DIVERSIDAD', 'activo' => true],
            ['id' => 7, 'description' => 'HÁBITAT', 'activo' => true],
            ['id' => 8, 'description' => 'NIÑEZ Y ADOLESCENCIA', 'activo' => true],
            ['id' => 9, 'description' => 'PROMOCIÓN Y PROTECCIÓN DE DERECHOS', 'activo' => true],
            ['id' => 10, 'description' => 'VENTANILLA ÚNICA', 'activo' => true],
            ['id' => 11, 'description' => 'VIVIENDA SOCIAL', 'activo' => true],
            ['id' => 1, 'description' => 'CENTROS BARRIALES', 'activo' => false],
            ['id' => 12, 'description' => 'CENTROS BARRIALES INFANCIA', 'activo' => true],
            ['id' => 13, 'description' => 'CENTROS BARRIALES JUVENTUD', 'activo' => true],
            ['id' => 14, 'description' => 'PERSONAS MAYORES', 'activo' => true],
        ];

        DB::table('dependencias')->insert($data);
    }
}
