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
        Schema::table('intervenciones_programa_social_cb', function (Blueprint $table) {
            $table->date('fecha')->nullable()->after('description');
        });
    }

    
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::create('intervenciones_programa_social_cb', function (Blueprint $table) {
            $table->dropColumn('fecha');
        });
    }
};
