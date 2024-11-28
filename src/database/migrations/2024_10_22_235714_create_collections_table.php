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
        Schema::create('collections', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('person_id');
            $table->text('address');
            $table->date('date');
            $table->unsignedBigInteger('punto_entrega_id');
            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('user_id');
            $table->timestamps();
    
            // Foreign key constraints
            $table->foreign('person_id')->references('id')->on('person')->onDelete('restrict');
            $table->foreign('punto_entrega_id')->references('id')->on('puntos_entrega')->onDelete('restrict');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('restrict');            
            $table->foreign('user_id')->references('id')->on('users')->onDelete('restrict');            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('collections');
    }
};
