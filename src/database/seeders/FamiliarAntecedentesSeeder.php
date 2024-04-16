<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FamiliarAntecedentesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['id' => 1, 'description' => 'No'],
            ['id' => 2, 'description' => 'Madre con Antecedente'],
            ['id' => 3, 'description' => 'Madre Actualmente'],
            ['id' => 4, 'description' => 'Padre con Antecedente'],
            ['id' => 5, 'description' => 'Padre Actualmente'],
        ];

        DB::table('familiar_antecedentes')->insert($data);
    }
}
