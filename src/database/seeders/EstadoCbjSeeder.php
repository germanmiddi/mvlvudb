<?php

namespace Database\Seeders;

use App\Models\Manager\EstadoCbj;
use Illuminate\Database\Seeder;

class EstadoCbjSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['id' => 1, 'description' => 'Activo'],
            ['id' => 2, 'description' => 'Regular'],
            ['id' => 3, 'description' => 'Baja'],
            ['id' => 4, 'description' => 'Egreso'],
            ['id' => 5, 'description' => 'No Participa']
        ];

        foreach ($data as $value) {
            EstadoCbj::updateOrCreate(['id' => $value['id']],$value);
        }
    }
}
