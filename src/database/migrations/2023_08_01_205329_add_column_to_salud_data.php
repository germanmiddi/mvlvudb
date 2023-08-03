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
            $table->date('fecha_apto_medico')->nullable()->after('libreta_vacunacion');
            $table->boolean('electrocardiograma',100 )->nullable()->after('fecha_apto_medico');
            $table->date('fecha_electrocardiograma')->nullable()->after('electrocardiograma');
            $table->boolean('medicacion')->nullable()->after('fecha_electrocardiograma');
            $table->string('name_medicacion', 100)->nullable()->after('medicacion');
            $table->string('dosis', 100)->nullable()->after('name_medicacion');
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
            $table->date('fecha_apto_medico')->nullable()->after('libreta_vacunacion');
            $table->boolean('electrocardiograma',100 )->nullable()->after('fecha_apto_medico');
            $table->date('fecha_electrocardiograma')->nullable()->after('electrocardiograma');
            $table->boolean('medicacion')->nullable()->after('fecha_electrocardiograma');
            $table->string('name_medicacion', 100)->nullable()->after('medicacion');
            $table->string('dosis', 100)->nullable()->after('name_medicacion');
        });
    }
};
