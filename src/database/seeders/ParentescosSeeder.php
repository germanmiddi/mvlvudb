<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ParentescosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['id' => 1, 'description' => 'Jefa/e'],
            ['id' => 2, 'description' => 'Madre'],
            ['id' => 3, 'description' => 'Padre'],
            ['id' => 4, 'description' => 'Conyuge'],
            ['id' => 5, 'description' => 'Pareja Conviviente'],
            ['id' => 6, 'description' => 'Madrastra/Padrastro'],
            ['id' => 7, 'description' => 'Hermana/o'],
            ['id' => 8, 'description' => 'Hermanastra/o Mayor de Edad'],
            ['id' => 9, 'description' => 'Hermana/o Menor de Edad'],
            ['id' => 10, 'description' => 'Hija/o - Hijastro/a'],
            ['id' => 11, 'description' => 'Abuela/o'],
            ['id' => 12, 'description' => 'Suegra/o'],
            ['id' => 13, 'description' => 'Tia/o'],
            ['id' => 14, 'description' => 'Nuera/Yerno'],
            ['id' => 15, 'description' => 'Nieta/o'],
            ['id' => 16, 'description' => 'Adulto/a Responsable'],
            ['id' => 17, 'description' => 'Hermana/o Menor de Edad'],
            ['id' => 18, 'description' => 'Otro Familiar'],
            ['id' => 19, 'description' => 'Otro No Familiar'],
        ];

        DB::table('parentescos')->insert($data);
    }
}
