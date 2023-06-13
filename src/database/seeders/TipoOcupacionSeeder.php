<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TipoOcupacionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['id' => 1, 'description' => 'PATRÓN/EMPLEADOR'],
            ['id' => 2, 'description' => 'CUENTA PROPIA'],
            ['id' => 3, 'description' => 'OBRERO O EMPLEADO SECTOR PRIVADO'],
            ['id' => 4, 'description' => 'OBRERO O EMPLEADO SECTOR PÚBLICO'],
            ['id' => 5, 'description' => 'SERVICIO DOMESTICO'],
            ['id' => 6, 'description' => 'DESEMPLEADO'],
            ['id' => 7, 'description' => 'JUBILADO/PENSIONADO'],
            ['id' => 8, 'description' => 'CHANGAS/TRABAJO INFORMAL'],
            ['id' => 10, 'description' => 'OTROS'],
            ['id' => 11, 'description' => 'NS/NR'],
            ['id' => 12, 'description' => 'AMA DE CASA'],
        ];

        DB::table('tipo_ocupacion')->insert($data);
    }
}
