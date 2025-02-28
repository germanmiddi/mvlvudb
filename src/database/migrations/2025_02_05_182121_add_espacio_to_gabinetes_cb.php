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
        Schema::table('gabinetes_cb', function (Blueprint $table) {
            $table->unsignedBigInteger('espacio_id')->nullable()->after('estado_id');

            $table->foreign('espacio_id')->references('id')->on('espacio_gabinete_cb')->onDelete('set null')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('gabinetes_cb', function (Blueprint $table) {
            $table->dropForeign(['espacio_id']);
            $table->dropColumn('espacio_id');
        });
    }
};
