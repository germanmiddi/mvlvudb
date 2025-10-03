<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CajasMotivosSuspensionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $motivos = [
            ['id' => 1, 'description' => 'Problemas de salud', 'activo' => 1],
            ['id' => 2, 'description' => 'Cambios en la situación socio-económica', 'activo' => 1],
            ['id' => 3, 'description' => 'Mal uso del beneficio', 'activo' => 1],
            ['id' => 4, 'description' => 'Retira persona no autorizada', 'activo' => 1],
        ];

        foreach ($motivos as $motivo) {
            DB::table('cajas_motivos_suspension')->updateOrInsert(
                ['id' => $motivo['id']],
                [
                    'description' => $motivo['description'],
                    'activo' => $motivo['activo'],
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            );
        }
    }
}

