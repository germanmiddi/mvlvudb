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
        Schema::table('cud', function (Blueprint $table) {
            $table->bigInteger('codigo')->nullable()->change();
        });
    }

    
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::create('cud', function (Blueprint $table) {
            $table->bigInteger('codigo')->nullable()->change();
        });
    }
};
