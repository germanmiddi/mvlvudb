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
        Schema::create('address_data', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('person_id');
            $table->unsignedBigInteger('localidad_id')->nullable();
            $table->unsignedBigInteger('pais_id')->nullable();
            $table->unsignedBigInteger('barrio_id')->nullable();
            $table->string('calle',100)->nullable();
            $table->string('number', 100)->nullable();
            $table->string('piso', 50)->nullable();
            $table->string('dpto', 50)->nullable();
            $table->decimal('latitude', 20, 18)->nullable();
            $table->decimal('longitude', 20, 18)->nullable();
            $table->string('google_address', 250)->nullable();
            $table->timestamps();

            $table->foreign('person_id')
                ->references('id')
                ->on('person')
                ->onDelete('NO ACTION')
                ->onUpdate('NO ACTION');

            $table->foreign('localidad_id')
                ->references('id')
                ->on('localidades')
                ->onDelete('NO ACTION')
                ->onUpdate('NO ACTION');

            $table->foreign('pais_id')
                ->references('id')
                ->on('paises')
                ->onDelete('NO ACTION')
                ->onUpdate('NO ACTION');

            $table->foreign('barrio_id')
                ->references('id')
                ->on('barrios')
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
        Schema::dropIfExists('address_data');
    }
};
