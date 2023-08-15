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
        Schema::create('entidades', function (Blueprint $table) {
            $table->id();
            $table->integer('num_entidad')->unique();
            $table->string('name', 100);
            $table->string('objeto',100)->nullable();            
            $table->string('address', 250)->nullable();
            $table->string('phone', 20)->nullable();
            $table->string('email', 50)->nullable();
            $table->string('solicitud_inscripcion', 100)->nullable();
            $table->string('personeria', 100)->nullable();
            $table->string('eximision', 100)->nullable();
            $table->string('observation', 100)->nullable();
            $table->date('fecha_inscripcion')->nullable();
            $table->date('fecha_fundacion')->nullable();
            $table->date('fecha_fin_mandato')->nullable();
            $table->date('fecha_memoria')->nullable();
            $table->date('fecha_asamblea')->nullable();
            $table->unsignedBigInteger('tipo_entidad_id')->nullable();
            $table->unsignedBigInteger('localidad_id')->nullable();
            $table->unsignedBigInteger('tipo_actividad_id')->nullable();
            $table->boolean('activo')->default(true);
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
        Schema::dropIfExists('entidades');
    }
};
