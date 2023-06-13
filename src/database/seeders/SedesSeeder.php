<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SedesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['id' => 3, 'description' => 'Habana'],
            ['id' => 5, 'description' => 'Munro'],
            ['id' => 6, 'description' => 'Villa Martelli'],
            ['id' => 4, 'description' => 'Las Flores'],
            ['id' => 1, 'description' => 'La Loma'],
            ['id' => 2, 'description' => 'El Ceibo'],
            ['id' => 8, 'description' => 'Madre Teresa'],
            ['id' => 9, 'description' => 'Juan Manuel Fangio'],
            ['id' => 7, 'description' => 'Sivori'],
        ];

        DB::table('sedes')->insert($data);
    }
}
