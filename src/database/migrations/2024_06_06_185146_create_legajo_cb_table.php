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
        Schema::create('legajos_cb', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sede_id')->nullable();
            $table->unsignedBigInteger('person_id');
            $table->unsignedBigInteger('estado_id')->nullable();
            $table->timestamps();

            $table->foreign('sede_id')
            ->references('id')
            ->on('sedes')
            ->onDelete('NO ACTION')
            ->onUpdate('NO ACTION');

            $table->foreign('person_id')
            ->references('id')
            ->on('person')
            ->onDelete('NO ACTION')
            ->onUpdate('NO ACTION');

            $table->foreign('estado_id')
            ->references('id')
            ->on('estado_cbj')
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
        Schema::dropIfExists('legajos_cb');
    }
};
