<?php

namespace Database\Seeders;

use App\Models\Manager\ColumnExport;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;


class ColumnExportSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['id' => 1, 'table' => 'person', 'column' => 'lastname', 'label' => 'Apellido', 'order' => 1],
            ['id' => 2, 'table' => 'person', 'column' => 'name', 'label' => 'Nombre', 'order' => 2],
            ['id' => 3, 'table' => 'person', 'column' => 'fecha_nac', 'label' => 'Fecha Nacimiento', 'order' => 3],
            ['id' => 4, 'table' => 'person', 'column' => 'num_documento', 'label' => 'N° de Documento', 'order' => 4],
            ['id' => 5, 'table' => 'person', 'column' => 'tipo_documento_id', 'label' => 'Tipo Documento', 'order' => 5],
            // Datos de Dirección
            ['id' => 6, 'table' => 'address_data', 'column' => 'calle', 'label' => 'Calle', 'order' => 6],
            ['id' => 7, 'table' => 'address_data', 'column' => 'number', 'label' => 'Numero', 'order' => 7],
            ['id' => 8, 'table' => 'address_data', 'column' => 'piso', 'label' => 'Piso', 'order' => 8],
            ['id' => 9, 'table' => 'address_data', 'column' => 'dpto', 'label' => 'Departamento', 'order' => 9],
            ['id' => 10, 'table' => 'address_data', 'column' => 'google_address', 'label' => 'Dirección Google', 'order' => 10],
            ['id' => 11, 'table' => 'localidades', 'column' => 'description', 'label' => 'Localidad', 'order' => 11],
            ['id' => 12, 'table' => 'paises', 'column' => 'description', 'label' => 'Pais', 'order' => 12],
            ['id' => 13, 'table' => 'barrios', 'column' => 'description', 'label' => 'Barrio', 'order' => 13],
            // Datos de Contacto
            ['id' => 14, 'table' => 'contact_data', 'column' => 'phone', 'label' => 'Telefono', 'order' => 14],
            ['id' => 15, 'table' => 'contact_data', 'column' => 'celular', 'label' => 'Celular', 'order' => 15],
            ['id' => 16, 'table' => 'contact_data', 'column' => 'email', 'label' => 'Email', 'order' => 16],
            // Datos de Salud
            ['id' => 17, 'table' => 'salud_data', 'column' => 'apto_medico', 'label' => 'Apto Medico', 'order' => 17],
            ['id' => 18, 'table' => 'salud_data', 'column' => 'libreta_vacunacion', 'label' => 'Libreta de Vacunación', 'order' => 18],
            ['id' => 19, 'table' => 'salud_data', 'column' => 'fecha_apto_medico', 'label' => 'Fecha Apto Medico', 'order' => 19],
            ['id' => 20, 'table' => 'salud_data', 'column' => 'electrocardiograma', 'label' => 'Electrocardiograma', 'order' => 20],
            ['id' => 21, 'table' => 'salud_data', 'column' => 'fecha_electrocardiograma', 'label' => 'Fecha Electrocardiograma', 'order' => 21],
            ['id' => 22, 'table' => 'salud_data', 'column' => 'medicacion', 'label' => 'Recibe Medicación', 'order' => 22],
            ['id' => 23, 'table' => 'salud_data', 'column' => 'name_medicacion', 'label' => 'Nombre Medicacion', 'order' => 23],
            ['id' => 24, 'table' => 'salud_data', 'column' => 'dosis', 'label' => 'Dosis Medicacion', 'order' => 24],
            ['id' => 25, 'table' => 'salud_data', 'column' => 'observacion', 'label' => 'Observacion de Salud', 'order' => 25],
            // Datos Sociales
            ['id' => 26, 'table' => 'tipo_ocupacion', 'column' => 'description', 'label' => 'Ocupación', 'order' => 26],
            ['id' => 27, 'table' => 'cobertura_medica', 'column' => 'description', 'label' => 'Cobertura Medica', 'order' => 27],
            ['id' => 28, 'table' => 'tipo_pension', 'column' => 'description', 'label' => 'Pensión', 'order' => 28],
            // Datos Adicionales
            ['id' => 29, 'table' => 'aditional_data', 'column' => 'cant_hijos', 'label' => 'Cantidad de Hijos', 'order' => 29],
            ['id' => 30, 'table' => 'tipo_vivienda', 'column' => 'description', 'label' => 'Tipo de Vivienda', 'order' => 30],
            ['id' => 31, 'table' => 'tipo_vinculo_familiar', 'column' => 'description', 'label' => 'Vinculo Familiar', 'order' => 31],
            ['id' => 32, 'table' => 'situacion_conyugal', 'column' => 'description', 'label' => 'Situación Conyugal', 'order' => 32],
            //Trámite
            ['id' => 33, 'table' => 'dependencias', 'column' => 'description', 'label' => 'Dependencia', 'order' => 33],
            ['id' => 34, 'table' => 'tipo_tramite', 'column' => 'description', 'label' => 'Tipo de Trámite', 'order' => 34],
        ];

        foreach ($data as $value) {
            ColumnExport::updateOrCreate(['id' => $value['id']],$value);
        }
    }
}