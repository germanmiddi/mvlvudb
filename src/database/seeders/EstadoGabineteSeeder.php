<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EstadoGabineteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['id' => 1, 'description' => 'En proceso'],
            ['id' => 2, 'description' => 'Alta'],
            ['id' => 3, 'description' => 'Baja'],
            ['id' => 4, 'description' => 'Derivado'],
            ['id' => 5, 'description' => 'No asiste']
        ];

        DB::table('estado_gabinete')->insert($data);
    }
}
