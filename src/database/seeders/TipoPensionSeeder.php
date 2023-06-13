<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TipoPensionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['id' => 1, 'description' => 'PENSIÓN'],
            ['id' => 2, 'description' => 'JUBILACIÓN'],
            ['id' => 3, 'description' => 'AMBOS'],
            ['id' => 4, 'description' => 'NO PERCIBE'],
        ];

        DB::table('tipo_pension')->insert($data);
    }
}
