<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SituacionConyugalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['id' => 1, 'description' => 'SOLTERA/O'],
            ['id' => 2, 'description' => 'CASADA/O'],
            ['id' => 3, 'description' => 'UNIDA/O DE HECHO - UNION CONVIVENCIAL - UNION CIVIL'],
            ['id' => 4, 'description' => 'VIUDA/O'],
            ['id' => 5, 'description' => 'SEPARADA/O'],
            ['id' => 6, 'description' => 'DIVORCIADA/O']
        ];

        DB::table('situacion_conyugal')->insert($data);
    }
}
