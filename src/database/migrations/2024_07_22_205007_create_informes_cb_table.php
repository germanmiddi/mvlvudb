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
        Schema::create('informes_cb', function (Blueprint $table) {
            $table->id();
            $table->text('description');
            $table->datetime('fecha_informe');
            $table->boolean('activo')->default(true);
            $table->unsignedBigInteger('profesional_id')->nullable();
            $table->unsignedBigInteger('legajo_id');
            $table->unsignedBigInteger('estado_id');
            $table->timestamps();

            $table->foreign('profesional_id')->references('id')->on('users')
                ->onDelete('NO ACTION')->onUpdate('NO ACTION');

            $table->foreign('legajo_id')->references('id')->on('legajos_cb')
                ->onDelete('NO ACTION')->onUpdate('NO ACTION');

            $table->foreign('estado_id')->references('id')->on('estados_informe_cb')
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
        Schema::dropIfExists('informes_cb');
    }
};
