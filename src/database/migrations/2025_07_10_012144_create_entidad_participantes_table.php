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
        Schema::create('entidad_participantes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('entidad_id')->constrained('entidades');
            $table->foreignId('person_id')->constrained('person');
            $table->foreignId('entidad_rol_id')->constrained('entidad_rols');
            $table->string('estado')->nullable();
            $table->string('observaciones')->nullable();
            $table->string('fecha_inicio')->nullable();
            $table->string('fecha_fin')->nullable();
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
        Schema::dropIfExists('entidad_participantes');
    }
};
