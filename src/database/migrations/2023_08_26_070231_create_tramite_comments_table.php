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
        Schema::create('tramite_comments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tramite_id')->constrained('tramites')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('dependencia_id')->contrained('dependencias')->onDelete('cascade');
            $table->text('content');
            $table->timestamps();


        });
    }

    public function down()
    {
        Schema::dropIfExists('tramite_comments');
    }    
};
