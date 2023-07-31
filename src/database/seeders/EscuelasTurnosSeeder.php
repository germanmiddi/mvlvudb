<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EscuelasTurnosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [1, 'Mañana'],
            [2, 'Tarde'],
            [3, 'Jornada Completa'],
            [4, 'Noche'],
            [5, 'Terminalidad Educativa vía Online'],    
        ];

        foreach ($data as $row) {
            DB::table('escuelas_turnos')->insert([
                'id' => $row[0],
                'description' => $row[1]
            ]);
        }
    }
}
