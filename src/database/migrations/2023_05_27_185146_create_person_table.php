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
        Schema::create('person', function (Blueprint $table) {
            $table->id();
            $table->string('lastname', 100);
            $table->string('name', 100);
            $table->date('fecha_nac')->nullable();
            $table->integer('num_documento');
            $table->string('num_cuit',15)->nullable();
            $table->foreignId('tipo_documento_id')->constrained('tipo_documento');
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
        Schema::dropIfExists('person');
    }
};
