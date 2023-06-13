<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TipoViviendaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['id' => 1, 'description' => 'CASA'],
            ['id' => 2, 'description' => 'CASILLA'],
            ['id' => 3, 'description' => 'DEPARTAMENTO'],
            ['id' => 4, 'description' => 'PIEZA EN INQUILINATO'],
            ['id' => 5, 'description' => 'PIEZA EN HOTEL FAMILIAR'],
            ['id' => 6, 'description' => 'SITUACIÓN DE CALLE'],
            ['id' => 7, 'description' => 'COMPLEJO HABITACIONAL'],
        ];

        DB::table('tipo_vivienda')->insert($data);
    }
}
