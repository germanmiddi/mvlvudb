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
        Schema::table('cajas_entrevistas', function (Blueprint $table) {
            $table->foreignId('motivo_suspension_id')->nullable()->after('status_id')->constrained('cajas_motivos_suspension')->onDelete('cascade');
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
            $table->dropForeign(['motivo_suspension_id']);
            $table->dropColumn('motivo_suspension_id');
        });
    }
};
