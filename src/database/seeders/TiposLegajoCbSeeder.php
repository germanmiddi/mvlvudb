<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TiposLegajoCbSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['id' => 1, 'description' => 'Centro Barrial Infancia'],
            ['id' => 2, 'description' => 'Centro Barrial Juventud'],
        ];

        DB::table('tipos_legajo_cb')->insert($data);
    }
}
