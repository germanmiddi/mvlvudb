<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ActividadesCbjSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['id' => 1, 'description' => 'Actividades Presenciales'],
            ['id' => 2, 'description' => 'Actividades Virtuales'],
            ['id' => 3, 'description' => 'Actividades Virtuales y Presenciales'],
            ['id' => 4, 'description' => 'Actividades en Otras Instituciones Convenidas con CBJ'],
        ];

        DB::table('actividades_cbj')->insert($data);
    }
}
