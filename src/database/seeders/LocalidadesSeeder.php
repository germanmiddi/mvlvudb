<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LocalidadesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['id' => 4, 'description' => 'CARAPACHAY', 'postal_code' => 1606],
            ['id' => 5, 'description' => 'FLORIDA', 'postal_code' => 1602],
            ['id' => 6, 'description' => 'FLORIDA OESTE', 'postal_code' => 1602],
            ['id' => 8, 'description' => 'LA LUCILA', 'postal_code' => 1636],
            ['id' => 9, 'description' => 'MUNRO', 'postal_code' => 1605],
            ['id' => 10, 'description' => 'OLIVOS', 'postal_code' => 1636],
            ['id' => 11, 'description' => 'VILLA MARTELLI', 'postal_code' => 1603],
            ['id' => 12, 'description' => 'VICENTE LOPEZ', 'postal_code' => 1638],
            ['id' => 14, 'description' => 'VILLA ADELINA', 'postal_code' => 1607],
            ['id' => 15, 'description' => 'NO DESCRIPTA', 'postal_code' => 9999],
        ];

        DB::table('localidades')->insert($data);
    }
}
