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
                        [ 'description' => 'abierto',
                          'created_at' => now(),
                          'updated_at' => now() ],
                        
                        [ 'description' => 'cerrado',
                          'created_at' => now(),
                          'updated_at' => now()],
        ];



        DB::table('tramite_estados')->insert($estados);

    }

}
            