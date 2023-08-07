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
        Schema::create('education_data', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('person_id');
            $table->unsignedBigInteger('nivel_educativo_id')->nullable();
            $table->unsignedBigInteger('estado_educativo_id')->nullable();
            $table->timestamps();

            $table->foreign('person_id')
                ->references('id')
                ->on('person')
                ->onDelete('NO ACTION')
                ->onUpdate('NO ACTION');

            $table->foreign('nivel_educativo_id')
                ->references('id')
                ->on('nivel_educativo')
                ->onDelete('NO ACTION')
                ->onUpdate('NO ACTION');

            $table->foreign('estado_educativo_id')
                ->references('id')
                ->on('estado_educativo')
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
        Schema::dropIfExists('education_data');
    }
};
