<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('escuelas_v2_turnos', function (Blueprint $table) {
            $table->unsignedBigInteger('escuela_id');
            $table->unsignedBigInteger('turno_id');

            $table->foreign('escuela_id')
                ->references('id')->on('escuelas_v2')
                ->onDelete('CASCADE')->onUpdate('CASCADE');

            $table->foreign('turno_id')
                ->references('id')->on('escuelas_turnos')
                ->onDelete('CASCADE')->onUpdate('CASCADE');

            $table->primary(['escuela_id', 'turno_id']);
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('escuelas_v2_turnos', function (Blueprint $table) {
            $table->dropForeign(['escuela_id']);
            $table->dropForeign(['turno_id']);
        });

        // Eliminar la tabla
        Schema::dropIfExists('escuelas_v2_turnos');
    }
};
