<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TipoDocumentoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['id' => 1, 'description' => 'DNI'],
            ['id' => 2, 'description' => 'Libreta Cívica'],
            ['id' => 3, 'description' => 'Libreta de Enrolamiento'],
            ['id' => 4, 'description' => 'Pasaporte'],
        ];

        DB::table('tipo_documento')->insert($data);
    }
}
