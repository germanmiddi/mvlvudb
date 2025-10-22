<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('padrones', function (Blueprint $table) {
            // Agregar nuevos campos
            $table->enum('estado_entrevistas', ['activo', 'inactivo'])->default('activo');
            $table->enum('estado_entregas', ['activo', 'inactivo'])->default('inactivo');
        });

        // Migrar datos existentes
        DB::table('padrones')->update([
            'estado_entrevistas' => DB::raw('CASE WHEN activo = 1 THEN "activo" ELSE "inactivo" END'),
            'estado_entregas' => 'inactivo' // Por defecto inactivo para migración
        ]);

        // Eliminar el campo activo después de migrar
        Schema::table('padrones', function (Blueprint $table) {
            $table->dropColumn('activo');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('padrones', function (Blueprint $table) {
            // Restaurar campo activo
            $table->boolean('activo')->default(true);
        });

        // Migrar datos de vuelta
        DB::table('padrones')->update([
            'activo' => DB::raw('CASE WHEN estado_entrevistas = "activo" THEN 1 ELSE 0 END')
        ]);

        // Eliminar nuevos campos
        Schema::table('padrones', function (Blueprint $table) {
            $table->dropColumn(['estado_entrevistas', 'estado_entregas']);
        });
    }
};
