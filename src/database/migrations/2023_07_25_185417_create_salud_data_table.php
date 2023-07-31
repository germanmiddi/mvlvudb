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
        Schema::create('salud_data', function (Blueprint $table) {
            $table->id();
            $table->boolean('apto_medico')->nullable();
            $table->boolean('libreta_vacunacion')->nullable();
            $table->longText('observacion')->nullable();
            $table->unsignedBigInteger('person_id')->nullable();
            $table->unsignedBigInteger('centro_salud_id')->nullable();
            $table->unsignedBigInteger('estado_salud_id')->nullable();
            $table->timestamps();

            $table->foreign('person_id')
                ->references('id')
                ->on('person')
                ->onDelete('NO ACTION')
                ->onUpdate('NO ACTION');

            $table->foreign('centro_salud_id')
                ->references('id')
                ->on('centros_salud')
                ->onDelete('NO ACTION')
                ->onUpdate('NO ACTION');

            $table->foreign('estado_salud_id')
                ->references('id')
                ->on('estados_salud')
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
