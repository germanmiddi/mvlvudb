<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProgramaSocialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [1, 'ASIGNACIÓN UNIVERSAL POR HIJO'],
            [2, 'ASIGNACIÓN UNIVERSAL POR EMBARAZO'],
            [3, 'ASIGNACIÓN UNIVERSAL POR HIJO CON DISCAPACIDAD'],
            [4, 'PENSIONES NO CONTRIBUTIVAS/GRACIABLES'],
            [5, 'SEGURO DE CAPACITACIÓN Y EMPLEO'],
            [6, 'OTROS PROGRAMAS DE EMPLEO'],
            [7, 'SUBSIDIOS MENSUALES PARA SALUD (PROSAR - PAMI)'],
            [8, 'TARJETAS, TICKETS, VALES O BONOS PARA COMPRA DE ALIMENTOS'],
            [9, 'BONO JUBILADOS - MVL'],
            [10, 'NO PERCIBE'],
            [11, 'TARJETA ALIMENTAR'],
            [12, 'ASISTENCIA ALIMENTARIA COVID 19'],
            [13, 'INGRESO FAMILIAR DE EMERGENCIA'],
        ];

        foreach ($data as $row) {
            DB::table('programa_social')->insert([
                'id' => $row[0],
                'description' => $row[1]
            ]);
        }
    }
}
