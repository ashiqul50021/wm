<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateManufacturePricesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('manufacture_prices', function (Blueprint $table) {
            $table->id();
            $table->integer('manufacture_id')->contrained('manufactures')->onDelete('cascade');
            $table->string('total_price')->nullable();
            $table->string('pay_amount')->nullable();
            $table->string('due_amount')->nullable();
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
        Schema::dropIfExists('manufacture_prices');
    }
}
