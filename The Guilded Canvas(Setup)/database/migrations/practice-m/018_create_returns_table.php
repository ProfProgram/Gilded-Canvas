<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('returns_table', function (Blueprint $table) {
            $table->id('Return_id');
            $table->unsignedBigInteger('Order_id');
            $table->unsignedBigInteger('Product_id');
            $table->unsignedBigInteger('User_id');
            $table->unsignedBigInteger('Admin_id');
            $table->string('Return_reason');
            $table->enum('Return_status', ['Pending', 'Approved', 'Rejected', 'Completed', 'Refunded', 'Cancelled'])->default('Pending');
            $table->datetime('Return_date');
            $table->timestamps();

            $table->foreign('Product_id')->references('Products_id')->on('products_table');
            $table->foreign('Order_id')->references('Order_detail')->on('orders_table');
            $table->foreign('User_id')->references('User_id')->on('users_table');
            $table->foreign('Admin_id')->references('Admin_id')->on('admin_table');
        });
    }

    public function down()
    {
        Schema::dropIfExists('returns_table');
    }
};