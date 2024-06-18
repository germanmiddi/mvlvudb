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
        Schema::create('detalles_cb', function (Blueprint $table) {
            $table->id();
            $table->date('fecha_inscripcion');
            $table->date('fecha_inicio')->nullable(false);
            $table->string('observacion')->nullable();
            $table->unsignedBigInteger('legajo_id');
            $table->timestamps();

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
        Schema::dropIfExists('detalles_cb');
    }
};
