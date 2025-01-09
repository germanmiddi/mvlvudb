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
        Schema::table('aditional_data', function (Blueprint $table) {
            //
            
            $table->unsignedBigInteger('nacionalidad')->nullable();
            $table->foreign('nacionalidad')->references('id')->on('paises');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('aditional_data', function (Blueprint $table) {
            $table->dropForeign(['nacionalidad']);
            $table->dropColumn('nacionalidad');
        });
    }
};
