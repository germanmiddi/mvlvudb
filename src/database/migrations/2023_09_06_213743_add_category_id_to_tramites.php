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
        Schema::table('tramites', function (Blueprint $table) {
            $table->foreignId('category_id')->nullable()->constrained('categories');
            $table->foreignId('modalidad_atencion_id')->nullable()->constrained('modalidad_atencion');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tramites', function (Blueprint $table) {
            $table->dropForeign(['category_id']);
            $table->dropColumn('category_id');
            $table->dropForeign(['modalidad_atencion_id']);
            $table->dropColumn('modalidad_atencion_id');
        });
    }
};
