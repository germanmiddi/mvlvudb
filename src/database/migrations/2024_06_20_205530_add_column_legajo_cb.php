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
        Schema::table('legajos_cb', function (Blueprint $table) {     
            $table->unsignedBigInteger('tipo_legajo_id')->nullable()->after('observacion');       

            $table->foreign('tipo_legajo_id')
                ->references('id')
                ->on('tipos_legajo_cb')
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
        Schema::table('legajos_cb', function (Blueprint $table) {
            $table->dropForeign(['tipo_legajo_id']);
            $table->dropColumn('tipo_legajo_id');
        });
    }
};
