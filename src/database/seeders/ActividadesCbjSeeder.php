<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Manager\ActividadCbj;
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
            ['id' => 4, 'description' => 'Actividades en Otras Instituciones Convenidas con CBJ']
        ];

        foreach ($data as $item) {
            ActividadCbj::updateOrCreate(
                ['id' => $item['id']],
                ['description' => $item['description']]
            );
        }
    }
}
