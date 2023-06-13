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
        Schema::create('person_programa_social', function (Blueprint $table) {
            $table->unsignedBigInteger('person_id');
            $table->unsignedBigInteger('programa_social_id');

            $table->foreign('person_id')
                ->references('id')
                ->on('person')
                ->onDelete('NO ACTION')
                ->onUpdate('NO ACTION');

            $table->foreign('programa_social_id')
                ->references('id')
                ->on('programa_social')
                ->onDelete('NO ACTION')
                ->onUpdate('NO ACTION');

            $table->primary(['person_id', 'programa_social_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('person_programa_social');
    }
};
