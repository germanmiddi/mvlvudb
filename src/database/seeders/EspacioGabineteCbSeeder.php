<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EspacioGabineteCbSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [1, 'Psicologia', '1'],
            [2, 'Psicopedagogia', '1'],
            [3, 'Ambos', '1'],
        ];

        foreach ($data as $row) {
            DB::table('espacio_gabinete_cb')->updateOrInsert([
                'id' => $row[0],
            ], [
                'description' => $row[1],
                'activo' => $row[2]
            ]);
        }
    }
}
