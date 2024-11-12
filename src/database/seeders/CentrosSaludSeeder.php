<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CentrosSaludSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['id' => 1, 'description' => 'CAPS Ravazzoli', 'activo' => true],
            ['id' => 2, 'description' => 'CAPS Blanca Acosta', 'activo' => true],
            ['id' => 3, 'description' => 'CAPS Illia', 'activo' => false],
            ['id' => 4, 'description' => 'CAPS El Ceibo', 'activo' => true],
            ['id' => 5, 'description' => 'CAPS Burman', 'activo' => true],
            ['id' => 6, 'description' => 'CAPS Rotger', 'activo' => true],
            ['id' => 7, 'description' => 'CAPS Cabral', 'activo' => true],
            ['id' => 8, 'description' => 'CAPS Burman', 'activo' => false],
            ['id' => 9, 'description' => 'CAPS  Barbero', 'activo' => true],
            ['id' => 10, 'description' => 'URI Burman', 'activo' => true],
            ['id' => 11, 'description' => 'URI Carrillo', 'activo' => true],
            ['id' => 12, 'description' => 'Centro Odontológico Paul Harris', 'activo' => true],
            ['id' => 13, 'description' => 'Hospital Belgrano', 'activo' => true],
            ['id' => 14, 'description' => 'Hospital Vicente Lopez (Houssay)', 'activo' => true],
            ['id' => 15, 'description' => 'Instituto Marini', 'activo' => true],
            ['id' => 16, 'description' => 'Maternidad Santa Rosa', 'activo' => true],
            ['id' => 17, 'description' => 'Otros', 'activo' => true],
            ['id' => 18, 'description' => 'CAPS Arcuri', 'activo' => true],
        ];

        DB::table('centros_salud')->insert($data);
    }
}
