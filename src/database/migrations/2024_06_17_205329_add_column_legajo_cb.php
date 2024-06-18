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
            $table->unsignedBigInteger('canal_atencion_id')->nullable()->after('estado_id');       

            $table->foreign('canal_atencion_id')
                ->references('id')
                ->on('canal_atencion')
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
            $table->dropForeign(['canal_atencion_id']);
            $table->dropColumn('canal_atencion_id');
        });
    }
};
