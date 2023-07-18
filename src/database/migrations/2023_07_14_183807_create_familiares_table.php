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
        Schema::create('familiares', function (Blueprint $table) {
            $table->id();
            $table->string('description', 100);
            $table->unsignedBigInteger('tramite_id');
            $table->unsignedBigInteger('person_id');
            $table->unsignedBigInteger('parentesco_id');
            $table->tinyInteger('activo')->default(1);
            $table->timestamps();

            $table->foreign('tramite_id')
                ->references('id')
                ->on('tramite')
                ->onDelete('NO ACTION')
                ->onUpdate('NO ACTION');
            
            $table->foreign('person_id')
                ->references('id')
                ->on('person')
                ->onDelete('NO ACTION')
                ->onUpdate('NO ACTION');

            $table->foreign('parentescos')
                ->references('id')
                ->on('dependencias')
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
        Schema::dropIfExists('familiares');
    }
};
