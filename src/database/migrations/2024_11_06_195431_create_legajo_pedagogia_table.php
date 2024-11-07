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
        Schema::create('legajo_pedagogia', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('legajo_id');
            $table->boolean('realizo_prueba');
            $table->datetime('fecha_prueba')->nullable();
            $table->unsignedBigInteger('estado_id')->nullable();
            $table->longText('detalles')->nullable();
            $table->string('profesional')->nullable();

            $table->foreign('legajo_id')->references('id')->on('legajos_cb')
                ->onDelete('NO ACTION')->onUpdate('NO ACTION');
            $table->foreign('estado_id')->references('id')->on('estado_pedagogia')
                ->onDelete('NO ACTION')->onUpdate('NO ACTION');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('legajo_pedagogia');
    }
};