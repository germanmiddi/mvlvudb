<?php

namespace Database\Seeders;

use App\Models\Manager\EstadoGabineteCB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EstadoGabineteCBSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['id' => 1, 'description' => 'No Participa', 'activo' => '1'],
            ['id' => 2, 'description' => 'Alta', 'activo' => '1'],
            ['id' => 3, 'description' => 'Derivado', 'activo' => '1'],
            ['id' => 4, 'description' => 'Psicologia', 'activo' => '0'],
            ['id' => 5, 'description' => 'Psicopedagogia', 'activo' => '0'],
            ['id' => 6, 'description' => 'Ambos', 'activo' => '0'],
            ['id' => 7, 'description' => 'Baja', 'activo' => '1'],
        ];

        foreach ($data as $d) {
            EstadoGabineteCB::updateOrCreate(
                [
                    'id' => $d['id'] // Condición por id
                ],
                [
                    'description' => $d['description'],
                    'activo' => $d['activo'],
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            );
        }

    }
}
