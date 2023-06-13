<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TipoVinculoFamiliarSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['id' => 1, 'description' => 'MADRE'],
            ['id' => 2, 'description' => 'PADRE'],
            ['id' => 3, 'description' => 'ABUELO/A RESPONSABLE'],
            ['id' => 4, 'description' => 'ADULTO/A RESPONSABLE'],
            ['id' => 5, 'description' => 'HERMANO/A MAYORES DE EDAD'],
            ['id' => 6, 'description' => 'TIO/A'],
            ['id' => 7, 'description' => 'PADRASTRO'],
            ['id' => 8, 'description' => 'MADRASTRA'],
            ['id' => 9, 'description' => 'HERMANASTRA/O MAYORES DE EDAD'],
            ['id' => 10, 'description' => 'OTRO'],
            ['id' => 11, 'description' => 'PAREJA CONVIVIENTE'],
            ['id' => 12, 'description' => 'HIJO/A'],
            ['id' => 13, 'description' => 'HERMANA/O MENOR DE EDAD'],
        ];

        DB::table('tipo_vinculo_familiar')->insert($data);
    }
}
