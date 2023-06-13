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
        Schema::create('tipo_tramite', function (Blueprint $table) {
            $table->id();
            $table->string('description', 100);
            $table->unsignedBigInteger('dependencia_id');
            $table->tinyInteger('activo')->default(1);
            $table->timestamps();

            $table->foreign('dependencia_id')
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
        Schema::dropIfExists('tipo_tramite');
    }
};
