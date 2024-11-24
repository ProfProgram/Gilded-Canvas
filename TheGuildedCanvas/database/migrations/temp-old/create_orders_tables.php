<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('Orders Details Table', function (Blueprint $table) {
            $table->increments('Orders_detail_id')->unique();
            $table->foreign('Order_id')->references('Order_id')->on('Orders details table')->onDelete('cascade');
            $table->foreign('Product_id')->references('Products_id')->on('Products table')->onDelete('cascade');
            $table->integer('Quantity');
            $table->decimal('Price_of_order',10,0);
        });

        Schema::table('Inventory', function (Blueprint $table) {
            $table->unsignedInteger('Order_id')->change();
            $table->foreign('Order_id')->references('Order_id')->on('Orders details table')->onDelete('cascade');
        });

        Schema::create('Orders Table', function (Blueprint $table) {
            $table->foreign('Orders_detail_id')->references('Orders_detail_id')->on('Orders details table')->onDelete('cascade');
            $table->decimal('Total_price', 10, 0);
            $table->dateTime('Order_data');
            $table->foreign('Admin_id')->references('Admin_id')->on('Admin table')->onDelete('cascade');
            $table->foreign('User_id')->references('User_id')->on('users_table')->onDelete('cascade');
            $table->enum('Status',['Pending','Shipped','Delivered','Cancelled'])->default('Pending');
            $table->timestamps();
        });

        Schema::create('Returns Table', function (Blueprint $table) {
            $table->increments('Return_id')->unique();
            $table->foreign('Order_id')->references('Order_id')->on('Orders details table')->onDelete('cascade');
            $table->foreign('Product_id')->references('Products_id')->on('Products table')->onDelete('cascade');
            $table->foreign('User_id')->references('User_id')->on('users_table')->onDelete('cascade');
            $table->foreign('Admin_id')->references('Admin_id')->on('Admin table')->onDelete('cascade');
            $table->string('Return_reason');
            $table->enum('Return_status',['Pending','Approved','Rejected','Completed','Refunded','Cancelled'])->default('Pending');
            $table->dateTime('Return_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('Orders Details Table');
        Schema::dropIfExists('Orders Table');
        Schema::dropIfExists('Returns Table');
    }
};
