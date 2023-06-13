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
        Schema::create('person_tramite', function (Blueprint $table) {
            $table->id();
            
            $table->unsignedBigInteger('person_id');
            $table->foreign('person_id')->references('id')->on('person')->onDelete('cascade')->onUpdate('cascade');
            
            $table->unsignedBigInteger('tramite_id');
            $table->foreign('tramite_id')->references('id')->on('tramites')->onDelete('cascade')->onUpdate('cascade');

            $table->unsignedBigInteger('rol_tramite_id');
            $table->foreign('rol_tramite_id')->references('id')->on('rol_tramite')->onDelete('cascade')->onUpdate('cascade');

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
        Schema::dropIfExists('person_tramite');
    }
};
