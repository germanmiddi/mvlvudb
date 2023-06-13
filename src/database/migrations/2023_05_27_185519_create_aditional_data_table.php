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
        Schema::create('aditional_data', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('person_id');
            $table->integer('cant_hijos')->nullable();
            $table->unsignedBigInteger('tipo_vivienda_id');
            $table->unsignedBigInteger('tipo_vinculo_familiar_id');
            $table->unsignedBigInteger('situacion_conyugal_id');
            $table->timestamps();

            $table->foreign('person_id')
                ->references('id')
                ->on('person')
                ->onDelete('NO ACTION')
                ->onUpdate('NO ACTION');

            $table->foreign('tipo_vivienda_id')
                ->references('id')
                ->on('tipo_vivienda')
                ->onDelete('NO ACTION')
                ->onUpdate('NO ACTION');

            $table->foreign('tipo_vinculo_familiar_id')
                ->references('id')
                ->on('tipo_vinculo_familiar')
                ->onDelete('NO ACTION')
                ->onUpdate('NO ACTION');

            $table->foreign('situacion_conyugal_id')
                ->references('id')
                ->on('situacion_conyugal')
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
        Schema::dropIfExists('aditional_data');
    }
};
