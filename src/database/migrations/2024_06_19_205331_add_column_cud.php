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
            $table->boolean('posee_cud')->nullable();
            $table->boolean('presento_cud')->nullable();
        });
    }

    
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cud', function (Blueprint $table) {
            $table->dropColumn('posee_cud');
            $table->dropColumn('presento_cud');
        });
    }
};
