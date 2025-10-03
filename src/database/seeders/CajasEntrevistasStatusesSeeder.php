<?php

namespace Database\Seeders;

use App\Models\Manager\CajasEntrevistasStatus;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CajasEntrevistasStatusesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['id' => 1,  'nombre' => 'PENDIENTE', 'descripcion' => 'Entrevista pendiente' ],
            ['id' => 2,  'nombre' => 'APROBADA', 'descripcion' => 'Entrevista aprobada' ],
            ['id' => 3,  'nombre' => 'RECHAZADA', 'descripcion' => 'Entrevista rechazada' ],
            ['id' => 4,  'nombre' => 'SUSPENDIDO', 'descripcion' => 'Entrevista suspendida' ]
        ];


        foreach ($data as $item) {
            CajasEntrevistasStatus::updateOrCreate(
                ['id' => $item['id']],
                [
                    'nombre' => $item['nombre'],
                    'descripcion' => $item['descripcion']
                ]
            );
        }

    }

}
