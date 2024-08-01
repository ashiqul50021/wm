<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDealerRequestConfirmProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dealer_request_confirm_products', function (Blueprint $table) {
            $table->id();
            $table->integer('request_confirm_id')->contrained('dealer_request_confirms')->onDelete('cascade');
            $table->integer('product_id')->contrained('products')->onDelete('cascade');
            $table->string('request_qty')->nullable();
            $table->string('confirm_qty')->nullable();
            $table->string('due_qty')->nullable();
            $table->string('unit_price')->nullable();
            $table->string('total_price')->nullable();
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
        Schema::dropIfExists('dealer_request_confirm_products');
    }
}
