<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BarriosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['localidad_id' => 6, 'description' => 'Las Flores', 'postal_code' => 1602],
            ['localidad_id' => 11, 'description' => 'La Fabriquita', 'postal_code' => 1603],
            ['localidad_id' => 10, 'description' => '1º de Julio', 'postal_code' => 1636],
            ['localidad_id' => 10, 'description' => '2º de abril', 'postal_code' => 1636],
            ['localidad_id' => 10, 'description' => '7º de mayo', 'postal_code' => 1636],
            ['localidad_id' => 10, 'description' => 'Gandara', 'postal_code' => 1636],
            ['localidad_id' => 10, 'description' => 'Valle Grande', 'postal_code' => 1636],
            ['localidad_id' => 10, 'description' => 'Panamericana', 'postal_code' => 1636],
            ['localidad_id' => 9, 'description' => 'Virgen de Luján', 'postal_code' => 1605],
            ['localidad_id' => 8, 'description' => 'El Ceibo', 'postal_code' => 1636],
            ['localidad_id' => 8, 'description' => 'Enamour', 'postal_code' => 1636],
            ['localidad_id' => 11, 'description' => 'Habana', 'postal_code' => 1603],
            ['localidad_id' => 10, 'description' => 'La Loma', 'postal_code' => 1636],
            ['localidad_id' => 10, 'description' => 'Sivori', 'postal_code' => null],
            ['localidad_id' => 10, 'description' => 'Fiat', 'postal_code' => 1636],
            ['localidad_id' => 10, 'description' => 'Borges', 'postal_code' => 1636],
            ['localidad_id' => 10, 'description' => 'Ramon Castro', 'postal_code' => 1636],
        ];

        DB::table('barrios')->insert($data);
    }
}
