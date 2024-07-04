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
        Schema::create('legajo_programa_social_cb', function (Blueprint $table) {
            $table->id();
            $table->datetime('fecha_inscripcion');
            $table->unsignedBigInteger('legajo_id');
            $table->unsignedBigInteger('programa_social_id');
            $table->unsignedBigInteger('profesional_id');
            $table->unsignedBigInteger('estado_id');
            $table->timestamps();

            $table->foreign('legajo_id')->references('id')->on('legajos')
                ->onDelete('NO ACTION')->onUpdate('NO ACTION');

            $table->foreign('programa_social_id')->references('id')->on('programas_sociales_cb')
                ->onDelete('NO ACTION')->onUpdate('NO ACTION');

            $table->foreign('profesional_id')->references('id')->on('users')
                ->onDelete('NO ACTION')->onUpdate('NO ACTION');

            $table->foreign('estado_id')->references('id')->on('estados_programa_social_cb')
                ->onDelete('NO ACTION')->onUpdate('NO ACTION');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('legajo_programa_social_cb');
    }
};
