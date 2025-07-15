<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('localidades', function (Blueprint $table) {
            $table->decimal('latitud', 10, 8)->nullable()->comment('Latitud del centro de la localidad');
            $table->decimal('longitud', 11, 8)->nullable()->comment('Longitud del centro de la localidad');
            $table->text('polygon')->nullable()->comment('Coordenadas del polígono de la localidad en formato JSON');

            // Agregar índice para búsquedas geográficas más eficientes
            $table->index(['latitud', 'longitud'], 'idx_localidades_coordinates');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('localidades', function (Blueprint $table) {
            $table->dropIndex('idx_localidades_coordinates');
            $table->dropColumn(['latitud', 'longitud', 'polygon']);
        });
    }
};
