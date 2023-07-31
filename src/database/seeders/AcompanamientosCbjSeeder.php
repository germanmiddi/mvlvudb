<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AcompanamientosCbjSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['id' => 1, 'description' => 'Eje Psicosocial'],
            ['id' => 2, 'description' => 'Eje Educación'],
            ['id' => 3, 'description' => 'Eje Talleres'],
            ['id' => 4, 'description' => 'Eje Salud'],
            ['id' => 5, 'description' => 'Eje Familias'],
            ['id' => 6, 'description' => 'Eje Empleo/Emprendimiento']
        ];

        DB::table('acompanamientos_cbj')->insert($data);
    }
}
