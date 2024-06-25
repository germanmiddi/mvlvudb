<?php

namespace Database\Seeders;

use App\Models\Manager\ModalidadAtencion;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ModalidadAtencionSeeder extends Seeder
{
    /**
     * Run the seeder.
     *
     * @return void
     */
    public function run()
    {
        
        ModalidadAtencion::updateOrCreate(
            ['description' => 'VIRTUAL'],
            ['created_at' => now(), 'updated_at' => now()]
        );
        ModalidadAtencion::updateOrCreate(
            ['description' => 'PRESENCIAL'],
            ['created_at' => now(), 'updated_at' => now()]
        );
        ModalidadAtencion::updateOrCreate(
            ['description' => 'TELEFÓNICA'],
            ['created_at' => now(), 'updated_at' => now()]
        );
        ModalidadAtencion::updateOrCreate(
            ['description' => 'WHATSAPP'],
            ['created_at' => now(), 'updated_at' => now()]
        );
        ModalidadAtencion::updateOrCreate(
            ['description' => 'MAIL'],
            ['created_at' => now(), 'updated_at' => now()]
        );
    }
}
