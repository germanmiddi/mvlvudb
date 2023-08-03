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
            $table->unsignedBigInteger('escuela_primaria_id')->nullable()->after('estado_educativo_id');
            $table->unsignedBigInteger('escuela_secundaria_id')->nullable()->after('escuela_primaria_id');
            $table->unsignedBigInteger('escuela_nocturna_id')->nullable()->after('escuela_secundaria_id');
            $table->unsignedBigInteger('orientacion_secundario_id')->nullable()->after('escuela_nocturna_id');
            $table->unsignedBigInteger('nivel_secundario_id')->nullable()->after('orientacion_secundario_id');
            $table->unsignedBigInteger('turno_nocturno_id')->nullable()->after('nivel_secundario_id');
            $table->unsignedBigInteger('dependencia_nocturno_id')->nullable()->after('turno_nocturno_id');
            
            $table->boolean('terciario')->nullable()->after('dependencia_nocturno_id');
            $table->string('name_terciario',100 )->nullable()->after('terciario');
            $table->string('carrera_terciario',100 )->nullable()->after('name_terciario');
            $table->string('anio_terciario',100 )->nullable()->after('carrera_terciario');
            $table->boolean('universitario')->nullable()->after('anio_terciario');
            $table->string('name_universitario',100 )->nullable()->after('universitario');
            $table->string('carrera_universitario',100 )->nullable()->after('name_universitario');
            $table->string('anio_universitario',100 )->nullable()->after('carrera_universitario');

            $table->foreign('escuela_primaria_id')
                ->references('id')
                ->on('escuelas')
                ->onDelete('NO ACTION')
                ->onUpdate('NO ACTION');
            
            $table->foreign('escuela_secundaria_id')
                ->references('id')
                ->on('escuelas')
                ->onDelete('NO ACTION')
                ->onUpdate('NO ACTION');

            $table->foreign('escuela_nocturna_id')
                ->references('id')
                ->on('escuelas')
                ->onDelete('NO ACTION')
                ->onUpdate('NO ACTION');
            
            $table->foreign('orientacion_secundario_id')
                ->references('id')
                ->on('orientaciones_escuela')
                ->onDelete('NO ACTION')
                ->onUpdate('NO ACTION');
            
            $table->foreign('nivel_secundario_id')
                ->references('id')
                ->on('nivel_educativo')
                ->onDelete('NO ACTION')
                ->onUpdate('NO ACTION');

            $table->foreign('turno_nocturno_id')
                ->references('id')
                ->on('escuelas_turnos')
                ->onDelete('NO ACTION')
                ->onUpdate('NO ACTION');
        
            $table->foreign('dependencia_nocturno_id')
                ->references('id')
                ->on('escuelas_dependencia')
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
        Schema::table('education_data', function (Blueprint $table) {
            $table->unsignedBigInteger('escuela_primaria_id')->nullable()->after('estado_educativo_id');
            $table->unsignedBigInteger('escuela_secundaria_id')->nullable()->after('escuela_primaria_id');
            $table->unsignedBigInteger('escuela_nocturna_id')->nullable()->after('escuela_secundaria_id');
            $table->unsignedBigInteger('orientacion_secundario_id')->nullable()->after('escuela_nocturna_id');
            $table->unsignedBigInteger('nivel_secundario_id')->nullable()->after('orientacion_secundario_id');
            $table->unsignedBigInteger('turno_nocturno_id')->nullable()->after('nivel_secundario_id');
            $table->unsignedBigInteger('dependencia_nocturno_id')->nullable()->after('turno_nocturno_id');
            
            $table->boolean('terciario')->nullable()->after('dependencia_nocturno_id');
            $table->string('name_terciaria',100 )->nullable()->after('terciario');
            $table->string('carrera_terciaria',100 )->nullable()->after('name_terciario');
            $table->string('anio_terciario',100 )->nullable()->after('carrera_terciario');
            $table->boolean('universitario')->nullable()->after('anio_terciario');
            $table->string('name_universitaria',100 )->nullable()->after('universitario');
            $table->string('carrera_universitaria',100 )->nullable()->after('name_universitario');
            $table->string('anio_universitario',100 )->nullable()->after('carrera_universitario');

            $table->foreign('escuela_primaria_id')
                ->references('id')
                ->on('escuelas')
                ->onDelete('NO ACTION')
                ->onUpdate('NO ACTION');
            
            $table->foreign('escuela_secundaria_id')
                ->references('id')
                ->on('escuelas')
                ->onDelete('NO ACTION')
                ->onUpdate('NO ACTION');

            $table->foreign('escuela_nocturna_id')
                ->references('id')
                ->on('escuelas')
                ->onDelete('NO ACTION')
                ->onUpdate('NO ACTION');
            
            $table->foreign('orientacion_secundario_id')
                ->references('id')
                ->on('orientaciones_escuela')
                ->onDelete('NO ACTION')
                ->onUpdate('NO ACTION');
            
            $table->foreign('nivel_secundario_id')
                ->references('id')
                ->on('nivel_educativo')
                ->onDelete('NO ACTION')
                ->onUpdate('NO ACTION');

            $table->foreign('turno_nocturno_id')
                ->references('id')
                ->on('escuelas_turnos')
                ->onDelete('NO ACTION')
                ->onUpdate('NO ACTION');
        
            $table->foreign('dependencia_nocturno_id')
                ->references('id')
                ->on('escuelas_dependencia')
                ->onDelete('NO ACTION')
                ->onUpdate('NO ACTION');
        });
    }
};
