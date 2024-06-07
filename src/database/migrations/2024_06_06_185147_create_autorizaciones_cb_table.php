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
        Schema::create('autorizaciones_cb', function (Blueprint $table) {
            $table->id();
            $table->boolean('apoyo_escolar')->default(false);
            $table->boolean('actividad_empleo')->default(false);
            $table->boolean('autorizacion_firmada')->default(false);
            $table->boolean('autorizacion_retirarse')->default(false);
            $table->boolean('autorizacion_uso_imagen')->default(false);
            $table->boolean('inscripcion_comedor')->default(false);
            $table->unsignedBigInteger('comedor_id')->nullable();
            $table->unsignedBigInteger('legajo_id');
            $table->timestamps();

            $table->foreign('comedor_id')
                ->references('id')
                ->on('comedores')
                ->onDelete('NO ACTION')
                ->onUpdate('NO ACTION');

            $table->foreign('legajo_id')
                ->references('id')
                ->on('legajos_cb')
                ->onDelete('NO ACTION')
                ->onUpdate('NO ACTION');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('autorizaciones_cb');
    }
};
