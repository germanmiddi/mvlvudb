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
            $table->integer('fecha_inicio')->nullable()->change();
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
            $table->date('fecha_inicio')->nullable()->change();
        });
    }
};
