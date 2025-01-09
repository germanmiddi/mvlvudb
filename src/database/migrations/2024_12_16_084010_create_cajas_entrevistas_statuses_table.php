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
        Schema::create('cajas_entrevistas_statuses', function (Blueprint $table) {
            $table->id();
            $table->string('nombre'); // Ej: Pendiente, Aprobada, Rechazada
            $table->string('descripcion')->nullable();            
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
        Schema::dropIfExists('cajas_entrevistas_statuses');
    }
};
