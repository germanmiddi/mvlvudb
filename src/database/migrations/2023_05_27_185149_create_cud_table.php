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
        Schema::create('cud', function (Blueprint $table) {
            $table->id();
            $table->integer('codigo');
            $table->string('diagnostico', 250);
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
        Schema::dropIfExists('cud');
    }
};
