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
        Schema::create('autoridades_entidades', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->string('phone',100)->nullable();            
            $table->unsignedBigInteger('cargo_id');
            $table->unsignedBigInteger('entidad_id');
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
        Schema::dropIfExists('autoridades_entidades');
    }
};
