<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EscuelasNivelesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [1, 'Sala 3', 't', 'f'],
            [2, 'Sala 4', 't', 'f'],
            [3, 'Sala 5', 't', 'f'],
            [4, '1 Grado Primaria', 't', 'f'],
            [5, '2 Grado Primaria', 't', 'f'],
            [6, '3 Grado Primaria', 't', 'f'],
            [7, '4 Grado Primaria', 't', 'f'],
            [8, '5 Grado Primaria', 't', 'f'],
            [9, '6 Grado Primaria', 't', 't'],
            [12, '7 Grado Primaria', 'f', 't'],
            [13, '1 Año Secundaria', 't', 't'],
            [14, '2 Año Secundaria', 't', 't'],
            [77, '3 Año Secundaria', 'f', 't'],
            [78, '4 Año Secundaria', 'f', 't'],
            [15, '5 Año Secundaria', 'f', 't'],
            [16, '6 Año Secundaria', 'f', 't']        
        ];

        foreach ($data as $row) {
            DB::table('escuelas_niveles')->insert([
                'id' => $row[0],
                'description' => $row[1],
                'cbi' => $row[2],
                'cbj' => $row[3],
            ]);
        }
    }
}
