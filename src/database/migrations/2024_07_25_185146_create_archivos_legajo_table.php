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
        Schema::create('archivos_legajo_cb', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->string('description', 250)->nullable();
            $table->string('ext', 10);
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
        Schema::dropIfExists('archivos_legajo_cb');
    }
};
