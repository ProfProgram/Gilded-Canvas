<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('products_table', function (Blueprint $table) {
            $table->id('Products_id');
            $table->unsignedBigInteger('Category_id');
            $table->integer('Stock_level');
            $table->string('Product_image');
            $table->text('Description');
            $table->timestamps();

            $table->foreign('Category_id')->references('Category_id')->on('category_table');
        });
    }

    public function down()
    {
        Schema::dropIfExists('products_table');
    }
};