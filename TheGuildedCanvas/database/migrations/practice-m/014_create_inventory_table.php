<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('inventory_table', function (Blueprint $table) {
            $table->id('Inventory_id');
            $table->unsignedBigInteger('Product_id');
            $table->unsignedBigInteger('Admin_id');
            $table->integer('Stock_in');
            $table->integer('Stock_out');
            $table->integer('Current_stock');
            $table->integer('Threshold_level');
            $table->timestamps();

            $table->foreign('Product_id')->references('Products_id')->on('products_table');
            $table->foreign('Admin_id')->references('Admin_id')->on('admin_table');
        });
    }

    public function down()
    {
        Schema::dropIfExists('inventory_table');
    }
};