<?php

namespace Database\Seeders;

use App\Models\Manager\TipoTramite;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TipoTramiteCBSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data =  [
            [
              "dependencia_id" => 13,
              "description" => "INSCRIPCIÓN A CENTROS BARRIALES",
              "activo" => 1,
            ]
          ];

          foreach ($data as $item) {
            TipoTramite::updateOrCreate(
                [
                    'dependencia_id' => $item['dependencia_id'],
                    'description' => $item['description'],
                ],
                [
                    'dependencia_id' => $item['dependencia_id'],
                    'description' => $item['description'],
                    'activo' => $item['activo']
                ]
            );
        }
    }
}
