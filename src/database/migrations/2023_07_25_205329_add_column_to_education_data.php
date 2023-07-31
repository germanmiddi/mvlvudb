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
        Schema::table('education_data', function (Blueprint $table) {
            $table->unsignedBigInteger('escuela_id')->nullable()->after('estado_educativo_id');
           $table->unsignedBigInteger('escuela_dependencia_id')->nullable()->after('escuela_id');
            $table->unsignedBigInteger('escuela_localidad_id')->nullable()->after('escuela_dependencia_id');
            $table->unsignedBigInteger('escuela_nivel_id')->nullable()->after('escuela_localidad_id');
            $table->unsignedBigInteger('escuela_turno_id')->nullable()->after('escuela_nivel_id');
            $table->boolean('permanencia')->nullable()->after('escuela_turno_id');
            $table->boolean('certificado_escolar')->nullable()->after('permanencia');
            $table->longText('observacion')->nullable()->after('certificado_escolar');

            $table->foreign('escuela_id')
                ->references('id')
                ->on('escuelas')
                ->onDelete('NO ACTION')
                ->onUpdate('NO ACTION');
            
            $table->foreign('escuela_dependencia_id')
                ->references('id')
                ->on('escuelas_dependencia')
                ->onDelete('NO ACTION')
                ->onUpdate('NO ACTION');

            $table->foreign('escuela_localidad_id')
                ->references('id')
                ->on('localidades')
                ->onDelete('NO ACTION')
                ->onUpdate('NO ACTION');

            $table->foreign('escuela_nivel_id')
                ->references('id')
                ->on('escuelas_niveles')
                ->onDelete('NO ACTION')
                ->onUpdate('NO ACTION');

            $table->foreign('escuela_turno_id')
                ->references('id')
                ->on('escuelas_turnos')
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
        Schema::create('education_data', function (Blueprint $table) {
            $table->unsignedBigInteger('escuela_id')->after('estado_educativo_id');
            $table->unsignedBigInteger('escuela_dependencia_id')->nullable()->after('escuela_id');
            $table->unsignedBigInteger('escuela_localidad_id')->nullable()->after('escuela_dependencia_id');
            $table->unsignedBigInteger('escuela_nivel_id')->nullable()->after('escuela_localidad_id');
            $table->unsignedBigInteger('escuela_turno_id')->nullable()->after('escuela_nivel_id');
            $table->boolean('permanencia')->nullable()->after('escuela_turno_id');
            $table->boolean('certificado_escolar')->nullable()->after('permanencia');
            $table->longText('observacion')->nullable()->after('certificado_escolar');

            $table->foreign('escuela_id')
                ->references('id')
                ->on('escuelas')
                ->onDelete('NO ACTION')
                ->onUpdate('NO ACTION');
            
            $table->foreign('escuela_dependencia_id')
                ->references('id')
                ->on('escuelas_dependencia')
                ->onDelete('NO ACTION')
                ->onUpdate('NO ACTION');

            $table->foreign('escuela_localidad_id')
                ->references('id')
                ->on('localidades')
                ->onDelete('NO ACTION')
                ->onUpdate('NO ACTION');

            $table->foreign('escuela_nivel_id')
                ->references('id')
                ->on('escuelas_niveles')
                ->onDelete('NO ACTION')
                ->onUpdate('NO ACTION');

            $table->foreign('escuela_turno_id')
                ->references('id')
                ->on('escuelas_turnos')
                ->onDelete('NO ACTION')
                ->onUpdate('NO ACTION');

        });
    }
};
