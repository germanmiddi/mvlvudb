<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CanalAtencionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['id' => 2, 'description' => 'CENTRO BARRIAL DE JUVENTUD'],
            ['id' => 1, 'description' => 'CENTRO BARRIAL DE INFANCIA'],
            ['id' => 3, 'description' => 'PUNTO DIGITAL'],
            ['id' => 4, 'description' => 'SEDE CALLE LIBERTAD'],
            ['id' => 5, 'description' => 'PORTAL LA LOMA'],
            ['id' => 6, 'description' => 'PORTAL LAS FLORES'],
            ['id' => 7, 'description' => 'SEC. DESARROLLO SOCIAL - SEDE YRIGOYEN'],
            ['id' => 8, 'description' => 'DIR. GENERO Y DIVERSIDAD'],
            ['id' => 9, 'description' => 'DIR. GESTIÓN TERRITORIAL'],
        ];

        DB::table('canal_atencion')->insert($data);
    }
}
