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
        Schema::table('archivos_legajo_cb', function (Blueprint $table) {            
            $table->unsignedBigInteger('area_id')->nullable()->after('legajo_id');

            $table->foreign('area_id')
                ->references('id')
                ->on('areas_legajo_cb')
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
        Schema::table('archivos_legajo_cb', function (Blueprint $table) {
            $table->dropForeign(['area_id']);
            $table->dropColumn('area_id');
        });
    }
};
