<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cbi_data', function (Blueprint $table) {
            $table->id();
            $table->integer('anio_inicio')->nullable();
            $table->boolean('aut_firmada')->nullable();
            $table->boolean('aut_retirarse')->nullable();
            $table->boolean('aut_uso_imagen')->nullable();
            $table->boolean('act_varias')->nullable();
            $table->boolean('act_esporadicas')->nullable();
            $table->boolean('comedor')->nullable();
            $table->unsignedBigInteger('tramite_id')->nullable();
            $table->unsignedBigInteger('estado_cbi_id')->nullable();
            $table->unsignedBigInteger('estado_gabinete_id')->nullable();
            $table->timestamps();

            $table->foreign('tramite_id')
                ->references('id')
                ->on('tramites')
                ->onDelete('NO ACTION')
                ->onUpdate('NO ACTION');

            $table->foreign('estado_cbi_id')
                ->references('id')
                ->on('estado_cbi')
                ->onDelete('NO ACTION')
                ->onUpdate('NO ACTION');

            $table->foreign('estado_gabinete_id')
                ->references('id')
                ->on('estado_gabinete')
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
        Schema::dropIfExists('cbi_data');
    }
};
