<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class TramiteEstadosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $estados = [ 
                        [ 'id'  => 1,
                          'description' => 'abierto',
                          'created_at' => now(),
                          'updated_at' => now() ],
                        
                        [ 'id'  => 2,
                          'description' => 'cerrado',
                          'created_at' => now(),
                          'updated_at' => now()],

                        [ 'id'  => 3,
                          'description' => 'en proceso',
                          'created_at' => now(),
                          'updated_at' => now()],
        ];



        DB::table('tramite_estados')->insert($estados);

    }

}
            