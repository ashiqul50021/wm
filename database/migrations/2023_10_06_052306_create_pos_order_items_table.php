<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePosOrderItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pos_order_items', function (Blueprint $table) {
            $table->id();
            $table->integer('pos_order_id')->contrained('pos_orders')->onDelete('cascade');
            $table->string('product_image')->nullable();
            $table->string('product_name')->nullable();
            $table->string('product_price')->nullable();
            $table->string('qty')->nullable();
            $table->string('product_discount')->nullable();
            $table->string('product_discount_type')->nullable();
            $table->string('product_total_price')->nullable();
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
        Schema::dropIfExists('pos_order_items');
    }
}
