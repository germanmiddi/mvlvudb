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
        Schema::create('social_data', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('person_id');
            $table->unsignedBigInteger('tipo_ocupacion_id')->nullable();
            $table->unsignedBigInteger('cobertura_medica_id')->nullable();
            $table->unsignedBigInteger('tipo_pension_id')->nullable();
            $table->unsignedBigInteger('programa_social_id')->nullable();
            $table->timestamps();

            $table->foreign('person_id')
                ->references('id')
                ->on('person')
                ->onDelete('NO ACTION')
                ->onUpdate('NO ACTION');

            $table->foreign('tipo_ocupacion_id')
                ->references('id')
                ->on('tipo_ocupacion')
                ->onDelete('NO ACTION')
                ->onUpdate('NO ACTION');

            $table->foreign('cobertura_medica_id')
                ->references('id')
                ->on('cobertura_medica')
                ->onDelete('NO ACTION')
                ->onUpdate('NO ACTION');

            $table->foreign('tipo_pension_id')
                ->references('id')
                ->on('tipo_pension')
                ->onDelete('NO ACTION')
                ->onUpdate('NO ACTION');

            $table->foreign('programa_social_id')
                ->references('id')
                ->on('programa_social')
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
        Schema::dropIfExists('social_data');
    }
};
