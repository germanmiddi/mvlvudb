<?php

namespace Database\Seeders;

use App\Models\Manager\EstadoCbj;
use App\Models\Manager\EstadoProgramaSocialCB;
use Illuminate\Database\Seeder;

class EstadoProgramaSocialCBSeeder extends Seeder
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
            ['id' => 3, 'description' => 'No Participa'],
            ['id' => 4, 'description' => 'Baja'],
            ['id' => 5, 'description' => 'Egreso'],
        ];

        foreach ($data as $value) {
            EstadoProgramaSocialCB::updateOrCreate(['id' => $value['id']],$value);
        }
    }
}
