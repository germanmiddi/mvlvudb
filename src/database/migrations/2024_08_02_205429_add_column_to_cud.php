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
            $table->text('vencimiento_cud')->nullable()->after('presento_cud');
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
            $table->dropColumn('vencimiento_cud');
        });
    }
};
