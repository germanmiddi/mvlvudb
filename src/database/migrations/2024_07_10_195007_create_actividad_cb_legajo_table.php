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
        Schema::create('actividad_cb_legajo', function (Blueprint $table) {
            $table->id();
            $table->datetime('fecha_inscripcion');
            $table->unsignedBigInteger('legajo_id');
            $table->unsignedBigInteger('actividad_id');
            $table->unsignedBigInteger('estado_id');
            $table->timestamps();

            $table->foreign('legajo_id')->references('id')->on('legajos_cb')
                ->onDelete('NO ACTION')->onUpdate('NO ACTION');

            $table->foreign('actividad_id')->references('id')->on('actividades_cb')
                ->onDelete('NO ACTION')->onUpdate('NO ACTION');

            $table->foreign('estado_id')->references('id')->on('estados_actividad_cb')
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
        Schema::dropIfExists('actividad_cb_legajo');
    }
};
