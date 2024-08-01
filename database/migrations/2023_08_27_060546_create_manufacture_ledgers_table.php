<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateManufactureLedgersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('manufacture_ledgers', function (Blueprint $table) {
            $table->id();
            $table->integer('worker_id')->contrained('users')->onDelete('cascade');
            $table->string('collected_by')->nullable();
            $table->string('invoice_no')->nullable();
            $table->string('debit')->nullable();
            $table->string('credit')->nullable();
            $table->string('total')->nullable();
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
        Schema::dropIfExists('manufacture_ledgers');
    }
}
