<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ModalidadAtencionSeeder extends Seeder
{
    /**
     * Run the seeder.
     *
     * @return void
     */
    public function run()
    {
        // Valores a insertar en la tabla modalidad_atencion
        $modalidades = ['VIRTUAL', 'PRESENCIAL', 'TELEFÓNICA'];

        foreach ($modalidades as $modalidad) {
            DB::table('modalidad_atencion')->insert([
                'description' => $modalidad,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
