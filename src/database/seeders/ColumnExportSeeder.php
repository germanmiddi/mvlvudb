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
            ['id' => 6, 'table' => 'address_data', 'column' => 'calle', 'needs' => 'address_data', 'label' => 'Calle', 'order' => 6],
            ['id' => 7, 'table' => 'address_data', 'column' => 'number', 'needs' => 'address_data', 'label' => 'Numero', 'order' => 7],
            ['id' => 8, 'table' => 'address_data', 'column' => 'piso', 'needs' => 'address_data', 'label' => 'Piso', 'order' => 8],
            ['id' => 9, 'table' => 'address_data', 'column' => 'dpto', 'needs' => 'address_data', 'label' => 'Departamento', 'order' => 9],
            ['id' => 10, 'table' => 'address_data', 'column' => 'google_address', 'needs' => 'address_data', 'label' => 'Dirección Google', 'order' => 10],
            ['id' => 11, 'table' => 'localidades', 'column' => 'description', 'needs' => 'address_data', 'joined_table_column' => 'localidad_id', 'label' => 'Localidad', 'order' => 11],
            ['id' => 12, 'table' => 'paises', 'column' => 'description', 'needs' => 'address_data', 'joined_table_column' => 'pais_id', 'label' => 'Pais', 'order' => 12],
            ['id' => 13, 'table' => 'barrios', 'column' => 'description', 'needs' => 'address_data', 'joined_table_column' => 'barrio_id', 'label' => 'Barrio', 'order' => 13],
            // Datos de Contacto
            ['id' => 14, 'table' => 'contact_data', 'column' => 'phone', 'needs' => 'contact_data', 'label' => 'Telefono', 'order' => 14],
            ['id' => 15, 'table' => 'contact_data', 'column' => 'celular', 'needs' => 'contact_data', 'label' => 'Celular', 'order' => 15],
            ['id' => 16, 'table' => 'contact_data', 'column' => 'email', 'needs' => 'contact_data', 'label' => 'Email', 'order' => 16],
            // Datos de Salud
            ['id' => 17, 'table' => 'salud_data', 'column' => 'apto_medico', 'needs' => 'salud_data', 'label' => 'Apto Medico', 'order' => 17],
            ['id' => 18, 'table' => 'salud_data', 'column' => 'libreta_vacunacion', 'needs' => 'salud_data', 'label' => 'Libreta de Vacunación', 'order' => 18],
            ['id' => 19, 'table' => 'salud_data', 'column' => 'fecha_apto_medico', 'needs' => 'salud_data', 'label' => 'Fecha Apto Medico', 'order' => 19],
            ['id' => 20, 'table' => 'salud_data', 'column' => 'electrocardiograma', 'needs' => 'salud_data', 'label' => 'Electrocardiograma', 'order' => 20],
            ['id' => 21, 'table' => 'salud_data', 'column' => 'fecha_electrocardiograma', 'needs' => 'salud_data', 'label' => 'Fecha Electrocardiograma', 'order' => 21],
            ['id' => 22, 'table' => 'salud_data', 'column' => 'medicacion', 'needs' => 'salud_data', 'label' => 'Recibe Medicación', 'order' => 22],
            ['id' => 23, 'table' => 'salud_data', 'column' => 'name_medicacion', 'needs' => 'salud_data', 'label' => 'Nombre Medicacion', 'order' => 23],
            ['id' => 24, 'table' => 'salud_data', 'column' => 'dosis', 'needs' => 'salud_data', 'label' => 'Dosis Medicacion', 'order' => 24],
            ['id' => 25, 'table' => 'salud_data', 'column' => 'observacion', 'needs' => 'salud_data', 'label' => 'Observacion de Salud', 'order' => 25],
            // Datos Sociales
            ['id' => 26, 'table' => 'tipo_ocupacion', 'column' => 'description', 'needs' => 'social_data', 'joined_table_column' => 'tipo_ocupacion_id', 'label' => 'Ocupación', 'order' => 26],
            ['id' => 27, 'table' => 'cobertura_medica', 'column' => 'description', 'needs' => 'social_data', 'joined_table_column' => 'cobertura_medica_id', 'label' => 'Cobertura Medica', 'order' => 27],
            ['id' => 28, 'table' => 'tipo_pension', 'column' => 'description', 'needs' => 'social_data', 'joined_table_column' => 'tipo_pension_id', 'label' => 'Pensión', 'order' => 28],
            // Datos Adicionales
            ['id' => 29, 'table' => 'aditional_data', 'column' => 'cant_hijos', 'needs' => 'aditional_data', 'label' => 'Cantidad de Hijos', 'order' => 29],
            ['id' => 30, 'table' => 'tipo_vivienda', 'column' => 'description', 'needs' => 'aditional_data', 'joined_table_column' => 'tipo_vivienda_id', 'label' => 'Tipo de Vivienda', 'order' => 30],
            ['id' => 31, 'table' => 'tipo_vinculo_familiar', 'column' => 'description', 'needs' => 'aditional_data', 'joined_table_column' => 'tipo_vinculo_familiar_id', 'label' => 'Vinculo Familiar', 'order' => 31],
            ['id' => 32, 'table' => 'situacion_conyugal', 'column' => 'description', 'needs' => 'aditional_data', 'joined_table_column' => 'situacion_conyugal_id', 'label' => 'Situación Conyugal', 'order' => 32],
            //Trámite
            ['id' => 33, 'table' => 'dependencias', 'column' => 'description', 'needs' => 'tramites', 'joined_table_column' => 'dependencia_id', 'label' => 'Dependencia', 'order' => 33],
            ['id' => 34, 'table' => 'tipo_tramite', 'column' => 'description', 'needs' => 'tramites', 'joined_table_column' => 'tipo_tramite_id', 'label' => 'Tipo de Trámite', 'order' => 34],
        ];

        foreach ($data as $value) {
            ColumnExport::updateOrCreate(['id' => $value['id']],$value);
        }
    }
}