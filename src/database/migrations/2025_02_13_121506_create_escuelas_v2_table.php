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
        Schema::create('escuelas_v2', function (Blueprint $table) {
            $table->id();
            $table->string('numero_sigla')->nullable();
            $table->string('nombre_completo');
            $table->string('direccion')->nullable();
            $table->unsignedBigInteger('localidad_id')->nullable();
            $table->string('telefono')->nullable();
            $table->string('mail')->nullable();
            $table->unsignedBigInteger('dependencia_id')->nullable();
            $table->boolean('activo');

            $table->foreign('localidad_id')
                ->references('id')->on('localidades')
                ->onDelete('SET NULL')->onUpdate('CASCADE');

            $table->foreign('dependencia_id')
                ->references('id')->on('escuelas_dependencia')
                ->onDelete('SET NULL')->onUpdate('CASCADE');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('escuelas_v2');
    }
};
