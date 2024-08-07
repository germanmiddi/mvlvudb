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
        Schema::table('salud_data', function (Blueprint $table) {            
            $table->text('vencimiento_apto_medico')->nullable()->after('fecha_apto_medico');
        });
    }

    
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('salud_data', function (Blueprint $table) {
            $table->dropColumn('vencimiento_apto_medico');
        });
    }
};
