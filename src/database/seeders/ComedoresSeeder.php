<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ComedoresSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['id' => 1, 'description' => 'El Ceibo'],
            ['id' => 2, 'description' => 'La Loma'],
            ['id' => 3, 'description' => 'Habana'],
            ['id' => 4, 'description' => 'Las Flores'],
            ['id' => 5, 'description' => 'Fangio']
        ];

        DB::table('comedores')->insert($data);
    }
}
