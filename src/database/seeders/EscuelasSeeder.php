<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EscuelasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            // Datos proporcionados en formato COPY de PostgreSQL
            [1, 'EP N° 1', true, false, false],
            [2, 'EP N° 10', true, false, false],
            [3, 'EP N° 11', true, false, false],
            [4, 'EP N° 12', true, false, false],
            [5, 'EP N° 13', true, false, false],
            [6, 'EP N° 14', true, false, false],
            [7, 'EP N° 15', true, false, false],
            [8, 'EP N° 16', true, false, false],
            [9, 'EP N° 17', true, false, false],
            [10, 'EP N° 18', true, false, false],
            [11, 'EP N° 19', true, false, false],
            [12, 'EP N° 2', true, false, false],
            [13, 'EP N° 20', true, false, false],
            [14, 'EP N° 28', true, false, false],
            [15, 'EP N° 3', true, false, false],
            [16, 'EP N° 30', true, false, false],
            [17, 'EP N° 31', true, false, false],
            [18, 'EP N° 32', true, false, false],
            [19, 'EP N° 4', true, false, false],
            [20, 'EP N° 5', true, false, false],
            [21, 'EP N° 6', true, false, false],
            [22, 'EP N° 7', true, false, false],
            [23, 'EP N° 8', true, false, false],
            [24, 'EP N° 9', true, false, false],
            [25, 'Escuela Parroquial Maria Auxiliadora', true, false, false],
            [26, 'Instituto Almafuerte', true, false, false],
            [27, 'Instituto Educación Integral Munro', true, false, false],
            [28, 'Instituto Esteban Echeverria', true, false, false],
            [29, 'Instituto Manuel Dorrego', true, false, false],
            [30, 'Colegio Maria Reina', true, false, false],
            [31, 'Colegio Virgen del Carmen', true, false, false],
            [32, 'Escuela 19', true, false, false],
            [33, 'Escuela N° 32', true, false, false],
            [34, 'Escuela N° 23', true, false, false],
            [35, 'Escuela N° 31', true, false, false],
            [36, 'Escuela N° 8', true, false, false],
            [37, 'Escuela Cornelio Saavedra', true, false, false],
            [38, 'San Ladislao', true, false, false],
            [39, 'Maria Auxiliadora', true, false, false],
            [41, 'EMPAS', false, true, false],
            [42, 'ESB N° 1', false, true, false],
            [43, 'ESB N° 21', false, true, false],
            [44, 'ESB N° 3', false, true, false],
            [45, 'ESB N° 4', false, true, false],
            [46, 'ESB N° 5', false, true, false],
            [47, 'ESB N° 6', false, true, false],
            [48, 'ESB N° 7', false, true, false],
            [49, 'ESB N° 8', false, true, false],
            [50, 'ESB N° 10', false, true, false],
            [51, 'ESB N° 11', false, true, false],
            [52, 'ESB N° 12', false, true, false],
            [53, 'ESB N° 13', false, true, false],
            [54, 'ESB N° 17', false, true, false],
            [55, 'ESB N° 15', false, true, false],
            [56, 'ESB N° 18', false, true, false],
            [57, 'ESB N°21', false, true, false],
            [58, 'ES N° 3', false, true, false],
            [59, 'ES N° 4', false, true, false],
            [60, 'ES N° 5', false, true, false],
            [61, 'ES N° 6', false, true, false],
            [62, 'ES N° 7', false, true, false],
            [63, 'ES N° 8', false, true, false],
            [64, 'ES N° 10', false, true, false],
            [65, 'ET N° 1', false, true, false],
            [66, 'ET N° 2', false, true, false],
            [67, 'ET N° 3', false, true, false],
            [68, 'ET N° 4', false, true, false],
            [69, 'ESB N° 23 (S.M.)', false, true, false],
            [70, 'ESB N° 44 (S.M.)', false, true, false],
            [71, 'Escuela de Comercio 15 de 15', false, true, false],
            [72, 'Bachillerato Popular Ñanderoga', false, true, false],
            [73, 'Colegio Maria Reina', false, true, false],
            [74, 'Escuela Parroquial Maria Auxiliadora', false, true, false],
            [75, 'Instituto Almafuerte', false, true, false],
            [76, 'Instituto Educación Integral Munro', false, true, false],
            [77, 'Instituto Esteban Echeverria', false, true, false],
            [78, 'Instituto Jose Hernandez', false, true, false],
            [79, 'Instituto Manuel Dorrego', false, true, false],
            [80, 'Centro de Adultos N° 703/1', false, false, true],
            [81, 'Centro de Adultos N° 704/1', false, false, true],
            [82, 'Centro de Adultos N° 706/2', false, false, true],
            [83, 'Centro de Adultos N° 707/2', false, false, true],
            [84, 'Centro de Adultos N° 708/1', false, false, true],
            [85, 'Centro de Adultos N° 709/2', false, false, true],
            [86, 'Terminalidad Online (Adultos 2000)', false, false, true],
            [87, 'Terminalidad Semipresencial (Esc. Mariano Moreno)', false, false, true],
            [88, 'OTROS', true, true, true],
            [40, 'Virgen del Carmen', true, true, false],
            [89, 'EES N° 9', false, true, false],
        ];

        // Define el nombre de la tabla
        $tableName = 'escuelas';

        // Inserta los datos en la tabla
        foreach ($data as $row) {
            DB::table('escuelas')->insert([
                'id' => $row[0],
                'description' => $row[1],
                'primaria' => $row[2],
                'secundaria' => $row[3],
                'nocturna' => $row[4]
            ]);
        }
        //DB::table($tableName)->insert($data);
    }
}
