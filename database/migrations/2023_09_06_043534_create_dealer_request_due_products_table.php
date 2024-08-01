<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDealerRequestDueProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dealer_request_due_products', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->contrained('users')->onDelete('cascade');
            $table->integer('product_id')->contrained('products')->onDelete('cascade');
            $table->string('qty')->nullable();
            $table->string('unit_price')->nullable();
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
        Schema::dropIfExists('dealer_request_due_products');
    }
}
