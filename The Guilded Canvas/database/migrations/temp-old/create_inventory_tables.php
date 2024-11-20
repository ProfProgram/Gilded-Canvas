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
        Schema::create('Category Table', function (Blueprint $table) {
            $table->increments('Category_id')->unique();
            $table->string('Category_name')->unique();
        });

        Schema::create('Products Table', function (Blueprint $table) {
            $table->increments('Products_id');
            $table->unsignedInteger('Category_id');
            $table->foreign('Category_id')->references('Category_id')->on('Category Table')->onDelete('cascade');
            $table->integer('Stock_level');
            $table->string('Product_image');
            $table->text('Description');
        });

        Schema::create('Inventory Table', function (Blueprint $table) {
            $table->increments('Inventory_id')->unique();
            $table->unsignedInteger('Products_id');
            $table->foreign('Products_id')->references('Products_id')->on('Products Table')->onDelete('cascade');
            $table->unsignedInteger('Order_id');
            $table->integer('Stock_in');
            $table->integer('Stock_out');
            $table->integer('Current_stock');
            $table->integer('Threshold_level');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('Category Table');
        Schema::dropIfExists('Products table');
        Schema::dropIfExists('Inventory table');
    }
};
