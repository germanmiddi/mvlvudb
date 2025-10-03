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
        Schema::create('padrones', function (Blueprint $table) {
            $table->id();
            $table->string('nombre'); // Ej: "2025 - lorem ipsum"
            $table->text('descripcion')->nullable(); // Ej: "Padrón 2025 para entrega de cajas"
            $table->boolean('activo')->default(true);
            $table->date('fecha_inicio');
            $table->date('fecha_fin')->nullable();
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
        Schema::dropIfExists('padrones');
    }
};
