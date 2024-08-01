<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVendorPosOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vendor_pos_orders', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->contrained('users')->onDelete('cascade');
            $table->integer('seller_id')->contrained('vendors')->onDelete('cascade');
            $table->string('invoice_no')->nullable();
            $table->string('sale_by')->contrained('users')->onDelete('cascade');
            $table->string('total')->nullable();
            $table->string('discount')->nullable();
            $table->string('paid')->nullable();
            $table->string('due')->nullable();
            $table->text('discription')->nullable();
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
        Schema::dropIfExists('vendor_pos_orders');
    }
}
