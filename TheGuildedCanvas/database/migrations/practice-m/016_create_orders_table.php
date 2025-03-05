<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('orders_table', function (Blueprint $table) {
            $table->id('Order_detail');
            $table->decimal('Total_price', 10, 0);
            $table->datetime('Order_data');
            $table->unsignedBigInteger('Admin_id');
            $table->unsignedBigInteger('User_id');
            $table->enum('Status', ['Pending', 'Shipped', 'Delivered', 'Cancelled'])->default('Pending');
            $table->timestamps();

            $table->foreign('Admin_id')->references('Admin_id')->on('admin_table');
            $table->foreign('User_id')->references('User_id')->on('users_table');
        });
    }

    public function down()
    {
        Schema::dropIfExists('orders_table');
    }
};