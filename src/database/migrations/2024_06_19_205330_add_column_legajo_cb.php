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
            $table->date('fecha_inscripcion');
            $table->date('fecha_inicio')->nullable(false);
            $table->string('observacion')->nullable();
            $table->unsignedBigInteger('responsable_id')->nullable()->after('observacion');       

            $table->foreign('responsable_id')
                ->references('id')
                ->on('person')
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
            $table->dropColumn('fecha_inscripcion');
            $table->dropColumn('fecha_inicio');
            $table->dropColumn('observacion');
            $table->dropForeign(['responsable_id']);
            $table->dropColumn('responsable_id');
        });
    }
};
