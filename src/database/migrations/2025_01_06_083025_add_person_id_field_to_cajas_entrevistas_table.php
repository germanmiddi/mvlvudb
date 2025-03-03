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
            $table->unsignedBigInteger('person_id')->after('id');
            
            $table->foreign('person_id')
                ->references('id')
                ->on('person')
                ->onDelete('cascade')
                ->onUpdate('cascade');
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
            $table->dropForeign(['person_id']);
            $table->dropColumn('person_id');
        });
    }
};
