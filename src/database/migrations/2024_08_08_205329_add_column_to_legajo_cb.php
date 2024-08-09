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
            $table->unsignedBigInteger('parentesco_id')->nullable()->after('responsable_id');

            $table->foreign('parentesco_id')
                ->references('id')
                ->on('parentescos')
                ->onDelete('NO ACTION')
                ->onUpdate('NO ACTION');
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
            $table->dropForeign(['parentesco_id']);
            $table->dropColumn('parentesco_id');
        });
    }
};
