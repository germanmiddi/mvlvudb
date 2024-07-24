<?php

namespace Database\Seeders;

use App\Models\Manager\EstadoActividadCB;
use App\Models\Manager\EstadoCbj;
use App\Models\Manager\EstadoProgramaSocialCb;
use Illuminate\Database\Seeder;

class EstadoInformeCBSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['id' => 1, 'description' => 'Activo']
        ];

        foreach ($data as $value) {
            EstadoActividadCB::updateOrCreate(['id' => $value['id']],$value);
        }
    }
}
