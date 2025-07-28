<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleCajasProfSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $roles = [
            [
                'name' => "APP-VUDS-FOR-OP-PROF-CAJA",
                'permissions' => 'Modulo CAJAS PROFESIONAL',
                'description' => 'Grupo Ventanilla Unica Desa Social - Modulo CAJAS'
            ],

        ];

        DB::table('roles')->insert($roles);

    }
}
