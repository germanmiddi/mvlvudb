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
        Schema::create('tramites', function (Blueprint $table) {
            $table->id();
            $table->date('fecha')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->string('observacion',250);
            $table->unsignedBigInteger('sede_id')->nullable();
            $table->unsignedBigInteger('canal_atencion_id');
            $table->unsignedBigInteger('tipo_tramite_id');
            $table->unsignedBigInteger('tipo_institucion_id')->nullable();
            $table->unsignedBigInteger('dependencia_id');
            $table->unsignedBigInteger('parentesco_id')->nullable();
            $table->timestamps();

            $table->foreign('sede_id')
                ->references('id')
                ->on('sedes')
                ->onDelete('NO ACTION')
                ->onUpdate('NO ACTION');

            $table->foreign('canal_atencion_id')
                ->references('id')
                ->on('canal_atencion')
                ->onDelete('NO ACTION')
                ->onUpdate('NO ACTION');

            $table->foreign('tipo_tramite_id')
                ->references('id')
                ->on('tipo_tramite')
                ->onDelete('NO ACTION')
                ->onUpdate('NO ACTION');
            
            $table->foreign('dependencia_id')
                ->references('id')
                ->on('dependencias')
                ->onDelete('NO ACTION')
                ->onUpdate('NO ACTION');

            $table->foreign('tipo_institucion_id')
                ->references('id')
                ->on('tipo_institucion')
                ->onDelete('NO ACTION')
                ->onUpdate('NO ACTION');
                
            $table->foreign('parentesco_id')
                ->references('id')
                ->on('parentescos')
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
        Schema::dropIfExists('tramites');
    }
};
