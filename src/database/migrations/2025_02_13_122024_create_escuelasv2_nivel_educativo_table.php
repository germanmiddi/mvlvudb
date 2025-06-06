<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('escuelasv2_nivel_educativo', function (Blueprint $table) {
            $table->unsignedBigInteger('escuela_id');
            $table->unsignedBigInteger('nivel_educativo_id');

            $table->foreign('escuela_id')
                ->references('id')
                ->on('escuelas_v2')
                ->onDelete('CASCADE')
                ->onUpdate('CASCADE');

            $table->foreign('nivel_educativo_id')
                ->references('id')
                ->on('nivel_educativo')
                ->onDelete('CASCADE')
                ->onUpdate('CASCADE');

            $table->primary(['escuela_id', 'nivel_educativo_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('escuelasv2_nivel_educativo');
    }
};
