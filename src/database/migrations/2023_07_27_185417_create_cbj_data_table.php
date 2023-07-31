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
        Schema::create('cbj_data', function (Blueprint $table) {
            $table->id();
            $table->integer('anio_inicio');
            $table->boolean('aut_firmada')->nullable();
            $table->boolean('aut_retirarse')->nullable();
            $table->boolean('aut_uso_imagen')->nullable();
            $table->boolean('act_empleo')->nullable();
            $table->boolean('apoyo_escolar')->nullable();
            $table->boolean('certificado_escolar')->nullable();
            $table->unsignedBigInteger('actividad_cbj_id')->nullable();
            $table->unsignedBigInteger('comedor_id')->nullable();
            $table->unsignedBigInteger('tramite_id')->nullable();
            $table->unsignedBigInteger('estado_cbj_id')->nullable();
            $table->unsignedBigInteger('acompanamiento_cbj_id')->nullable();
            $table->timestamps();

            $table->foreign('tramite_id')
                ->references('id')
                ->on('tramites')
                ->onDelete('NO ACTION')
                ->onUpdate('NO ACTION');

            $table->foreign('comedor_id')
                ->references('id')
                ->on('comedores')
                ->onDelete('NO ACTION')
                ->onUpdate('NO ACTION');

            $table->foreign('actividad_cbj_id')
                ->references('id')
                ->on('actividades_cbj')
                ->onDelete('NO ACTION')
                ->onUpdate('NO ACTION');
            
            $table->foreign('acompanamiento_cbj_id')
                ->references('id')
                ->on('acompanamientos_cbj')
                ->onDelete('NO ACTION')
                ->onUpdate('NO ACTION');

            $table->foreign('estado_cbj_id')
                ->references('id')
                ->on('estado_cbj')
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
        Schema::dropIfExists('cbj_data');
    }
};
