<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddExtraFieldToAdminPosListsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('admin_pos_lists', function (Blueprint $table) {
            $table->string('paid')->nullable();
            $table->string('due')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('admin_pos_lists', function (Blueprint $table) {
            $table->dropColumn('paid');
            $table->dropColumn('due');
        });
    }
}
