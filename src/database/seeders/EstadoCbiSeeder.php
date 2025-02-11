<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EstadoCbiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['id' => 1, 'description' => 'Activo'],
            ['id' => 2, 'description' => 'Baja'],
            ['id' => 3, 'description' => 'Egresado'],
            ['id' => 4, 'description' => 'inactivo'],
            ['id' => 5, 'description' => 'Solo comedor'],

            ['id' => 6, 'description' => 'Regular'],
            ['id' => 7, 'description' => 'Solo Vacaciones']
        ];

        foreach ($data as $state) {
            DB::table('estado_cbi')->updateOrInsert(
                ['id' => $state['id']], 
                ['description' => $state['description']] 
            );
        }
    }
}
