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
            $table->integer('status_updated_by')->nullable();
            $table->date('status_updated_at')->nullable();
            
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
            $table->dropColumn('status_updated_by');
            $table->dropColumn('status_updated_at');
        });
    }
};

