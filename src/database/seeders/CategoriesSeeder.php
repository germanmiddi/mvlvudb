<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriesSeeder extends Seeder
{
    /**
     * Run the seeder.
     *
     * @return void
     */
    public function run()
    {
        // Valores a insertar en la tabla modalidad_atencion
        
            DB::table('categories')->insert([
                'dependencia_id' => 6,
                'nombre' => 'GÉNERO',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            DB::table('categories')->insert([
                'dependencia_id' => 6,
                'nombre' => 'DIVERSIDAD SEXUAL',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        
    }
}
