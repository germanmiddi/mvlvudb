<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EstadoCbjSeeder extends Seeder
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
            ['id' => 2, 'description' => 'Inactivo'],
            ['id' => 3, 'description' => 'Baja'],
            ['id' => 4, 'description' => 'Egreso'],
            ['id' => 5, 'description' => 'Solo Comedor']
        ];

        DB::table('estado_cbj')->insert($data);
    }
}
