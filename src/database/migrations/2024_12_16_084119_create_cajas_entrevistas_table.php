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
        Schema::create('cajas_entrevistas', function (Blueprint $table) {
            $table->id();
            $table->date('fecha');
            $table->foreignId('entrevistador_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('puntos_entrega_id')->constrained('puntos_entrega')->onDelete('cascade');
            $table->foreignId('status_id')->constrained('cajas_entrevistas_statuses')->onDelete('cascade');
            $table->foreignId('created_by')->constrained('users')->onDelete('cascade');

            $table->string('estudios')->nullable();
            $table->boolean('vive_solo')->nullable();
            $table->integer('cant_convivientes')->nullable();
            $table->string('tenencia')->nullable();
            $table->integer('pago_inquilino')->nullable();
            $table->integer('ambientes')->nullable();

            $table->string('trabajo')->nullable();
            $table->integer('ingresos_trabajo')->nullable();
            $table->string('otra_actividad')->nullable();
            $table->boolean('tiene_pami')->nullable();
            $table->boolean('tiene_obra_social')->nullable();
            $table->string('obra_social')->nullable();
            $table->string('tratamiento_medico')->nullable();
            $table->string('medicacion')->nullable();
            $table->string('discapacidad')->nullable();




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
        Schema::dropIfExists('cajas_entrevistas');
    }
};
