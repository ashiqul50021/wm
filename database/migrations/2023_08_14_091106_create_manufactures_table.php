<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateManufacturesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('manufactures', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->contrained('users')->onDelete('cascade');
            $table->integer('product_id')->contrained('users')->onDelete('cascade');
            $table->string('manufacture_quantity')->nullable();
            $table->string('manufacture_part')->nullable();
            $table->string('manufacture_code')->nullable();
            $table->string('manufacture_price')->nullable();
            $table->string('total_price')->nullable();
            $table->string('is_confirm')->nullable();
            $table->string('is_complete')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('manufactures');
    }
}
