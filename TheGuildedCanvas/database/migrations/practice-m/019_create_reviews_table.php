<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('reviews_table', function (Blueprint $table) {
            $table->id('Review_id');
            $table->unsignedBigInteger('Product_id');
            $table->unsignedBigInteger('User_id');
            $table->integer('Rating');
            $table->text('Review');
            $table->timestamps();

            $table->foreign('Product_id')->references('Products_id')->on('products_table');
            $table->foreign('User_id')->references('User_id')->on('users_table');
        });
    }

    public function down()
    {
        Schema::dropIfExists('reviews_table');
    }
};