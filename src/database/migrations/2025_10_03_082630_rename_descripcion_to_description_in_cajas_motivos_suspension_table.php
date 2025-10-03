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
        Schema::table('cajas_motivos_suspension', function (Blueprint $table) {
            $table->renameColumn('descripcion', 'description');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cajas_motivos_suspension', function (Blueprint $table) {
            $table->renameColumn('description', 'descripcion');
        });
    }
};
