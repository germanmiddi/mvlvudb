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
            ['id' => 1, 'description' => 'No Participa'],
            ['id' => 2, 'description' => 'Alta'],
            ['id' => 3, 'description' => 'Derivado'],
            ['id' => 4, 'description' => 'Psicologia'],
            ['id' => 5, 'description' => 'Psicopedagogia'],
            ['id' => 6, 'description' => 'Ambos']
        ];

        foreach ($data as $d) {
            EstadoGabineteCB::updateOrCreate(
                [
                    'id' => $d['id'] // Condición por id
                ], 
                [
                    'description' => $d['description'],
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            );
        }

    }
}
