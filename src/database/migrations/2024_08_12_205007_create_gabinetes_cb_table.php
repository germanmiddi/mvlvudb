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
        Schema::create('gabinetes_cb', function (Blueprint $table) {
            $table->id();
            $table->text('observacion')->nullable( );
            $table->unsignedBigInteger('legajo_id');
            $table->unsignedBigInteger('estado_id')->nullable();
            $table->timestamps();

            $table->foreign('legajo_id')->references('id')->on('legajos_cb')
                ->onDelete('NO ACTION')->onUpdate('NO ACTION');

            $table->foreign('estado_id')->references('id')->on('estados_gabinete_cb')
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
        Schema::dropIfExists('gabinetes_cb');
    }
};
