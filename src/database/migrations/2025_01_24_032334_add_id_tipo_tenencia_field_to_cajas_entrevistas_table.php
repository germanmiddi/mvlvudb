<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::table('cajas_entrevistas', function (Blueprint $table) {
            $table->unsignedBigInteger('habitacional_tipo_tenencia_id')->nullable();
            $table->boolean('has_hijos')->nullable();
            $table->integer('cant_hijos')->nullable();
            $table->integer('cant_personas_trabajando')->nullable();
            $table->boolean('conviviente_discapacidad')->nullable();

            $table->text('observaciones')->nullable();

            $table->foreign('habitacional_tipo_tenencia_id')
                ->references('id')
                ->on('habitacional_tipo_tenencia')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cajas_entrevistas', function (Blueprint $table) {

            $table->dropForeign(['habitacional_tipo_tenencia_id']);
            $table->dropColumn('habitacional_tipo_tenencia_id');
            $table->dropColumn('has_hijos');
            $table->dropColumn('cant_hijos');
            $table->dropColumn('cant_personas_trabajando');
            $table->dropColumn('conviviente_discapacidad');
            $table->dropColumn('observaciones');
            //
        });
    }
};
