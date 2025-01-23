<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleCajasSeeder extends Seeder
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
                'name' => "APP-VUDS-FOR-OP-CAJA",
                'permissions' => 'Modulo CAJAS',
                'description' => 'Grupo Ventanilla Unica Desa Social - Modulo CAJAS'
            ],

        ];

        DB::table('roles')->insert($roles);

    }
}
