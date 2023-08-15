<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CargosAutoridadesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['id' => 1, 'description' => 'Presidente'],
            ['id' => 2, 'description' => 'Secretario'],
            ['id' => 3, 'description' => 'Tesorero'],
            ['id' => 4, 'description' => 'Referente'],
        ];

        DB::table('cargos_autoridades')->insert($data);
    }
}
