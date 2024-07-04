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
        Schema::create('intervenciones_programa_social_cb', function (Blueprint $table) {
            $table->id();
            $table->text('description');
            $table->boolean('activo')->default(true);
            $table->unsignedBigInteger('profesional_id')->nullable();
            $table->unsignedBigInteger('legajo_programa_social_cb_id');
            $table->timestamps();

            $table->foreign('profesional_id')->references('id')->on('users')
                ->onDelete('NO ACTION')->onUpdate('NO ACTION');

            $table->foreign('legajo_programa_social_cb_id')->references('id')->on('legajo_programa_social_cb')
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
        Schema::dropIfExists('intervenciones_programa_social_cb');
    }
};
