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
        Schema::create('entidad_rols', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('description')->nullable();
            $table->timestamps();
        });

        // Insertar los roles por defecto
        DB::table('entidad_rols')->insert([
            ['name' => 'Presidente', 'description' => 'Presidente de la entidad'],
            ['name' => 'Secretario', 'description' => 'Secretario de la entidad'],
            ['name' => 'Tesorero', 'description' => 'Tesorero de la entidad'],
            ['name' => 'Referente', 'description' => 'Referente de la entidad'],
            ['name' => 'Miembro', 'description' => 'Miembro de la entidad'],
        ]);

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('entidad_rols');
    }
};
