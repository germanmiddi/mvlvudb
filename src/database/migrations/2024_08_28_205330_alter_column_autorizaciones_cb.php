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
        Schema::table('autorizaciones_cb', function (Blueprint $table) {     
            $table->boolean('apoyo_escolar')->nullable()->change();
            $table->boolean('actividad_empleo')->nullable()->change();
            $table->boolean('autorizacion_firmada')->nullable()->change();
            $table->boolean('autorizacion_retirarse')->nullable()->change();
            $table->boolean('autorizacion_uso_imagen')->nullable()->change();
            $table->boolean('inscripcion_comedor')->nullable()->change();
        });
    }

    
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('autorizaciones_cb', function (Blueprint $table) {
            $table->boolean('apoyo_escolar')->default(false)->change();
            $table->boolean('actividad_empleo')->default(false)->change();
            $table->boolean('autorizacion_firmada')->default(false)->change();
            $table->boolean('autorizacion_retirarse')->default(false)->change();
            $table->boolean('autorizacion_uso_imagen')->default(false)->change();
            $table->boolean('inscripcion_comedor')->default(false)->change();
        });
    }
};
