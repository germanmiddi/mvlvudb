<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LocalidadesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['id' => 4, 'description' => 'CARAPACHAY', 'postal_code' => 1606],
            ['id' => 5, 'description' => 'FLORIDA', 'postal_code' => 1602],
            ['id' => 6, 'description' => 'FLORIDA OESTE', 'postal_code' => 1602],
            ['id' => 8, 'description' => 'LA LUCILA', 'postal_code' => 1636],
            ['id' => 9, 'description' => 'MUNRO', 'postal_code' => 1605],
            ['id' => 10, 'description' => 'OLIVOS', 'postal_code' => 1636],
            ['id' => 11, 'description' => 'VILLA MARTELLI', 'postal_code' => 1603],
            ['id' => 12, 'description' => 'VICENTE LOPEZ', 'postal_code' => 1638],
            ['id' => 14, 'description' => 'VILLA ADELINA', 'postal_code' => 1607],
            ['id' => 15, 'description' => 'NO DESCRIPTA', 'postal_code' => 9999],

            // Adicional para el uso de Entidad
            ['id' => 13, 'description' => 'C.A.B.A', 'postal_code' => null],
            ['id' => 16, 'description' => 'SAN MARTIN', 'postal_code' => null],
            ['id' => '17', 'description' => 'San Isidro', 'postal_code' => null],
            /*
            3	"Florida" => Es necesario modificar por ID 5, existe previamente
            4	"La Lucila" => Existe coincide
            5	"Munro" => Es necesario modificar por ID 9, existe previamente
            6	"Olivos" => Es necesario modificar por ID 10, existe previamente
            7	"Villa Adelina" => Es necesario modificar por ID 14, existe previamente
            8	"Vicente Lopez" => Es necesario modificar por ID 12, existe previamente
            9	"Florida Oeste" => Es necesario modificar por ID 6, existe previamente
            10	"Carapachay" => Es necesario modificar por ID 4, existe previamente
            16	"Villa Martelli" => Es necesario modificar por ID 14, existe previamente
            13	"C.A.B.A." => Nueva
            14	"San Martín" => Nueva Se cambia por ID 16
            15	"Otras" => Coincide
            */
        ];

        DB::table('localidades')->insert($data);
    }
}
