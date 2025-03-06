<?php

namespace Database\Seeders;

use App\Models\Manager\EscuelaTurno;
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
            [1, 'Mañana', '1'],
            [2, 'Tarde', '1'],
            [3, 'Jornada Completa', '0'],
            [4, 'Noche', '1'],
            [5, 'Terminalidad Educativa vía Online', '0'],
        ];

        foreach ($data as $row) {
            EscuelaTurno::updateOrCreate(
                ['id' => $row['0']],
                ['description' => $row['1'], 'activo' => $row['2']]
            );
        }
    }
}
