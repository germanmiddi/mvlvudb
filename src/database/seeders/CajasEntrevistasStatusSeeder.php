<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Manager\CajasEntrevistasStatus;

class CajasEntrevistasStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        CajasEntrevistasStatus::updateOrCreate([
            'nombre' => 'PENDIENTE',
            'descripcion' => 'Entrevista pendiente'
        ]);

        CajasEntrevistasStatus::updateOrCreate([
            'nombre' => 'APROBADA',
            'descripcion' => 'Entrevista aprobada'
        ]);

        CajasEntrevistasStatus::updateOrCreate([
            'nombre' => 'RECHAZADA',
            'descripcion' => 'Entrevista rechazada'
        ]);


    }
}
