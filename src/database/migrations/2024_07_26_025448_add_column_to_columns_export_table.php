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
        Schema::table('columns_export', function (Blueprint $table) {
            $table->string('needs')->nullable()->after('column');
            $table->string('joined_table_column')->nullable()->after('needs');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('columns_export', function (Blueprint $table) {
            $table->dropColumn('needs');
            $table->dropColumn('joined_table_column');
        });
    }
};
