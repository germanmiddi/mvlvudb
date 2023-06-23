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
            ['id' => 2, 'description' => 'Conyuge'],
            ['id' => 3, 'description' => 'Hija/o - Hijastro/a'],
            ['id' => 4, 'description' => 'Nuera/Yerno'],
            ['id' => 5, 'description' => 'Nieta/o'],
            ['id' => 6, 'description' => 'Madre/Padre'],
            ['id' => 7, 'description' => 'Suegra/o'],
            ['id' => 8, 'description' => 'Hermana/o'],
            ['id' => 9, 'description' => 'Otro Familiar'],
        ];

        DB::table('parentescos')->insert($data);
    }
}
