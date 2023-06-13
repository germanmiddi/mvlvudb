<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PaisesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['id' => 1, 'description' => 'ARGENTINA'],
            ['id' => 2, 'description' => 'BOLIVIA'],
            ['id' => 3, 'description' => 'BRASIL'],
            ['id' => 4, 'description' => 'CHILE'],
            ['id' => 5, 'description' => 'COLOMBIA'],
            ['id' => 6, 'description' => 'ECUADOR'],
            ['id' => 7, 'description' => 'PARAGUAY'],
            ['id' => 8, 'description' => 'PERU'],
            ['id' => 9, 'description' => 'URUGUAY'],
            ['id' => 10, 'description' => 'VENEZUELA'],
            ['id' => 11, 'description' => 'ESPAÑA'],
            ['id' => 12, 'description' => 'ITALIA'],
            ['id' => 13, 'description' => 'COREA'],
            ['id' => 14, 'description' => 'CHINA'],
            ['id' => 15, 'description' => 'OTRO'],
            ['id' => 99, 'description' => 'NS/NC'],
        ];

        DB::table('paises')->insert($data);
    }
}
