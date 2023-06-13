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
        Schema::create('contact_data', function (Blueprint $table) {
            $table->id();
            $table->string('phone', 100)->nullable();
            $table->string('celular', 100)->nullable();
            $table->string('email', 100)->nullable();
            $table->unsignedBigInteger('person_id');
            $table->timestamps();

            $table->foreign('person_id')
                ->references('id')
                ->on('person')
                ->onDelete('NO ACTION')
                ->onUpdate('NO ACTION');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('contact_data');
    }
};
