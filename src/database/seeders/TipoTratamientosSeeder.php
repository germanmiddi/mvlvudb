<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TipoTratamientosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['id' => 1, 'description' => 'Psicologia'],
            ['id' => 2, 'description' => 'Psicopedagogia'],
            ['id' => 3, 'description' => 'Combinado']
        ];

        DB::table('tipo_tratamientos')->insert($data);
    }
}
