<?php

namespace Database\Seeders;

use App\Models\Manager\EstadoActividadCB;
use App\Models\Manager\EstadoCbj;
use App\Models\Manager\EstadoProgramaSocialCb;
use Illuminate\Database\Seeder;

class EstadoActividadCBSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['id' => 1, 'description' => 'Activo'],
            ['id' => 2, 'description' => 'Regular'],
            ['id' => 3, 'description' => 'No Participa'],
            ['id' => 4, 'description' => 'Baja'],
            ['id' => 5, 'description' => 'Solo Vacaciones'],
        ];

        foreach ($data as $value) {
            EstadoActividadCB::updateOrCreate(['id' => $value['id']],$value);
        }
    }
}
