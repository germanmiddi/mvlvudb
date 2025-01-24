<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Manager\TipoTenencia;

class TipoTenenciaSeeder extends Seeder
{
    public function run()
    {
        TipoTenencia::updateOrCreate(['nombre' => 'Propia', 'descripcion' => 'Propia']);
        TipoTenencia::updateOrCreate(['nombre' => 'Alquilada', 'descripcion' => 'Alquilada']);
        TipoTenencia::updateOrCreate(['nombre' => 'Ocupada', 'descripcion' => 'Ocupada']);
        TipoTenencia::updateOrCreate(['nombre' => 'Subarrendada', 'descripcion' => 'Subarrendada']);
        TipoTenencia::updateOrCreate(['nombre' => 'Ocupada por terceros', 'descripcion' => 'Ocupada por terceros']);
        TipoTenencia::updateOrCreate(['nombre' => 'Propia', 'descripcion' => 'Propia']);
        TipoTenencia::updateOrCreate(['nombre' => 'Alquilada', 'descripcion' => 'Alquilada']);
        TipoTenencia::updateOrCreate(['nombre' => 'Cedida', 'descripcion' => 'Cedida']);
        TipoTenencia::updateOrCreate(['nombre' => 'Tomada/Ocupada', 'descripcion' => 'Tomada/Ocupada']);
        TipoTenencia::updateOrCreate(['nombre' => 'Situacion de calle', 'descripcion' => 'Situación de calle']);

    }
}
