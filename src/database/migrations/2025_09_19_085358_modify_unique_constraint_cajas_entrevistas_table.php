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
        Schema::table('cajas_entrevistas', function (Blueprint $table) {
            // Agregar índice único compuesto por person_id y padron_id
            $table->unique(['person_id', 'padron_id'], 'unique_person_padron');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cajas_entrevistas', function (Blueprint $table) {
            // Eliminar índice único compuesto
            $table->dropUnique('unique_person_padron');
        });
    }
};
