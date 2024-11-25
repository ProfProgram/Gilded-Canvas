<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('orders_details_table', function (Blueprint $table) {
            $table->id('Order_detail_id');
            $table->unsignedBigInteger('Order_id');
            $table->unsignedBigInteger('Product_id');
            $table->integer('Quantity');
            $table->decimal('Price_of_order', 10, 0);
            $table->timestamps();

            $table->foreign('Product_id')->references('Products_id')->on('products_table');
            $table->foreign('Order_id')->references('Order_detail')->on('orders_table');
        });
    }

    public function down()
    {
        Schema::dropIfExists('orders_details_table');
    }
};