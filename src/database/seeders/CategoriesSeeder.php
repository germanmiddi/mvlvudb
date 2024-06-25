<?php

namespace Database\Seeders;

use App\Models\Manager\Category;
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
        // Valores a insertar o actualizar en la tabla categories
        Category::updateOrCreate(
            ['dependencia_id' => 6, 'nombre' => 'GÉNERO'],
            ['created_at' => now(), 'updated_at' => now()]
        );
        Category::updateOrCreate(
            ['dependencia_id' => 6, 'nombre' => 'DIVERSIDAD SEXUAL'],
            ['created_at' => now(), 'updated_at' => now()]
        );
        Category::updateOrCreate(
            ['dependencia_id' => 6, 'nombre' => 'VIVAMOS SIN VIOLENCIA'],
            ['created_at' => now(), 'updated_at' => now()]
        );
        
    }
}
