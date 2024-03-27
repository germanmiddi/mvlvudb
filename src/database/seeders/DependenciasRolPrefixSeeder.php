<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DependenciasRolPrefixSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('dependencias')->where('id', 2)->update(['rol_prefix' => 'DIS']); // Discapacidad
        DB::table('dependencias')->where('id', 3)->update(['rol_prefix' => 'ENT']); // Entidades Intermedias
        DB::table('dependencias')->where('id', 5)->update(['rol_prefix' => 'FOR']); // Fortalecimiento
        DB::table('dependencias')->where('id', 6)->update(['rol_prefix' => 'GEN']); // Genero
        DB::table('dependencias')->where('id', 7)->update(['rol_prefix' => 'HAB']); // Habitat
        DB::table('dependencias')->where('id', 8)->update(['rol_prefix' => 'NIN']); // Niñez
        DB::table('dependencias')->where('id', 9)->update(['rol_prefix' => 'PPD']); // Promocion
        DB::table('dependencias')->where('id', 10)->update(['rol_prefix' => 'VUDS-VU']); // Ventanilla Unica
        DB::table('dependencias')->where('id', 11)->update(['rol_prefix' => 'VIV']); // Vivienda Social
        DB::table('dependencias')->where('id', 12)->update(['rol_prefix' => 'CBI']); // CBI
        DB::table('dependencias')->where('id', 13)->update(['rol_prefix' => 'CBJ']); // CBJ
        DB::table('dependencias')->where('id', 14)->update(['rol_prefix' => 'PM']); // Personas Mayores
    }
}
