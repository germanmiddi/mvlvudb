<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BarriosUpdateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['localidad_id' => 9, 'description' => 'El conventillo'],
            ['localidad_id' => 9, 'description' => 'Vigen de Lujan y Carregal'],
            ['localidad_id' => 8, 'description' => 'El Ceibo y Eramur'],
            ['localidad_id' => 9, 'description' => 'Gral Belgrano'],
            ['localidad_id' => 4, 'description' => 'Silveyra'],
            ['localidad_id' => 9, 'description' => 'Villa Colombo'],
            ['localidad_id' => 14, 'description' => 'Santa Fe'],
            ['localidad_id' => 10, 'description' => 'Gandara'],
            ['localidad_id' => 10, 'description' => 'La Loma'],
            ['localidad_id' => 10, 'description' => 'La Colonia'],
            ['localidad_id' => 6, 'description' => 'Las Flores'],
            ['localidad_id' => 6, 'description' => 'Prodal'],
            ['localidad_id' => 11, 'description' => 'La Fabriquita'],
            ['localidad_id' => 11, 'description' => 'La Fabriquita 2'],
            ['localidad_id' => 11, 'description' => 'Alsina'],
            ['localidad_id' => 11, 'description' => 'La Habanita'],
            
        ];

        DB::table('barrios')->insert($data);
    }
}
