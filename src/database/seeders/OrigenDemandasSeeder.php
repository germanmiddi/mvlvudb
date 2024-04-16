<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrigenDemandasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['id' => 1, 'description' => 'Centro Barrial'],
            ['id' => 2, 'description' => 'Familia'],
            ['id' => 3, 'description' => 'Escuela'],
            ['id' => 4, 'description' => 'Salud'],
        ];

        DB::table('origen_demandas')->insert($data);
    }
}
