<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EstadoPedagogia extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['id' => 1, 'description' => 'Logrado'],
            ['id' => 2, 'description' => 'En proceso'],
            ['id' => 3, 'description' => 'No logrado'],
        ];

        DB::table('estado_pedagogia')->insert($data);
    }
}
