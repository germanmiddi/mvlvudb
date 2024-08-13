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
        Schema::create('emprendedores_cb', function (Blueprint $table) {
            $table->id();
            $table->datetime('fecha_inscripcion')->nullable();
            $table->datetime('fecha_finalizacion')->nullable();
            $table->boolean('participa')->nullable();
            $table->unsignedBigInteger('legajo_id');
            $table->timestamps();

            $table->foreign('legajo_id')->references('id')->on('legajos_cb')
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
        Schema::dropIfExists('emprendedores_cb');
    }
};
