<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class NivelEducativoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['id' => 1, 'description' => 'INICIAL (JARDIN/PREESCOLAR)'],
            ['id' => 3, 'description' => 'PRIMARIO'],
            ['id' => 5, 'description' => 'SECUNDARIO'],
            ['id' => 7, 'description' => 'TERCIARIO'],
            ['id' => 9, 'description' => 'UNIVERSITARIO'],
            ['id' => 99, 'description' => 'NS/NC'],
            ['id' => 10, 'description' => 'EDUCACION ESPECIAL'],
            ['id' => 11, 'description' => 'CENTRO EDUCATIVO TERAPEUTICO'],
            ['id' => 12, 'description' => 'CENTRO DE DIA'],
        ];

        DB::table('nivel_educativo')->insert($data);
    }
}
