<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Database\Seeders\PadronSeeder;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Crear padrones directamente en la migración
        \DB::table('padrones')->insert([
            [
                'nombre' => '2024 - Padrón Inicial',
                'descripcion' => 'Padrón inicial para entrevistas existentes antes de la implementación del sistema de padrones',
                'activo' => true,
                'fecha_inicio' => '2024-01-01',
                'fecha_fin' => null,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nombre' => '2025 - Entrega Regular',
                'descripcion' => 'Padrón 2025 para entrega regular de cajas de alimentos',
                'activo' => true,
                'fecha_inicio' => '2025-01-01',
                'fecha_fin' => '2025-12-31',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nombre' => '2025 - Re categorización',
                'descripcion' => 'Padrón 2025 para re categorización de beneficiarios',
                'activo' => true,
                'fecha_inicio' => '2025-06-01',
                'fecha_fin' => '2025-12-31',
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);

        // Verificar si la columna ya existe antes de crearla
        if (!Schema::hasColumn('cajas_entrevistas', 'padron_id')) {
            Schema::table('cajas_entrevistas', function (Blueprint $table) {
                // Agregar campo padron_id como nullable primero
                $table->unsignedBigInteger('padron_id')->nullable()->after('person_id');
            });
        }

        // Asignar padrón por defecto a registros existentes
        $padronInicial = \DB::table('padrones')->where('nombre', '2024 - Padrón Inicial')->first();
        if ($padronInicial) {
            \DB::table('cajas_entrevistas')->update(['padron_id' => $padronInicial->id]);
        }

        // Verificar si la foreign key ya existe
        $foreignKeys = \DB::select("
            SELECT CONSTRAINT_NAME
            FROM information_schema.KEY_COLUMN_USAGE
            WHERE TABLE_SCHEMA = DATABASE()
            AND TABLE_NAME = 'cajas_entrevistas'
            AND COLUMN_NAME = 'padron_id'
            AND CONSTRAINT_NAME != 'PRIMARY'
        ");

        if (empty($foreignKeys)) {
            Schema::table('cajas_entrevistas', function (Blueprint $table) {
                // Hacer el campo obligatorio después de asignar valores
                $table->unsignedBigInteger('padron_id')->nullable(false)->change();

                // Crear foreign key
                $table->foreign('padron_id')
                      ->references('id')
                      ->on('padrones')
                      ->onDelete('cascade')
                      ->onUpdate('cascade');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cajas_entrevistas', function (Blueprint $table) {
            // Eliminar foreign key
            $table->dropForeign(['padron_id']);

            // Eliminar columna
            $table->dropColumn('padron_id');
        });

        // Eliminar padrones creados
        \DB::table('padrones')->whereIn('nombre', [
            '2024 - Padrón Inicial',
            '2025 - Entrega Regular',
            '2025 - Re categorización'
        ])->delete();
    }
};
