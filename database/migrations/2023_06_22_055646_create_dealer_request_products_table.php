<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDealerRequestProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dealer_request_products', function (Blueprint $table) {
            $table->id();
            $table->integer('dealer_request_id')->contrained('dealer_requests')->onDelete('cascade');
            $table->integer('product_id');
            $table->unsignedTinyInteger('is_varient')->default(0)->comment('1=>Varient Product, 0=>Normal Product');
            $table->longtext('variation')->nullable();
            $table->string('qty', 100)->nullable();
            $table->float('price',20,2)->default(0.00);
            $table->string('delivery_status')->default('pending');
            $table->string('request_status')->default(0);
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
        Schema::dropIfExists('dealer_request_products');
    }
}
