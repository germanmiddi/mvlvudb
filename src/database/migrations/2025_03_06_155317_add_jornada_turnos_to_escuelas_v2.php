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
        Schema::table('escuelas_v2', function (Blueprint $table) {
            $table->unsignedBigInteger('jornada_id')->nullable()->after('dependencia_id');

            $table->foreign('jornada_id')
                ->references('id')->on('escuelas_jornadas')
                ->onDelete('SET NULL')->onUpdate('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('escuelas_v2', function (Blueprint $table) {
            $table->dropForeign(['jornada_id']);
            $table->dropColumn('jornada_id');
        });
    }
};
