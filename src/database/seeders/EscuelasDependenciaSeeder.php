<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EscuelasDependenciaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['id' => 1, 'description' => 'Municipal'],
            ['id' => 2, 'description' => 'Provincial'],
            ['id' => 3, 'description' => 'Nacional'],
            ['id' => 4, 'description' => 'Privada'],
        ];

        DB::table('escuelas_dependencia')->insert($data);
    }
}
