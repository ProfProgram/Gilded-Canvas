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
        /*
        * NEEDS NO FOREIGN KEY
        */
        if (!Schema::hasTable('users_table')) {
            Schema::create('users_table', function (Blueprint $table) {
                $table->increments('user_id');
                $table->string('name');
                $table->string('email')->unique();
                $table->timestamp('email_verified_at')->nullable();
                $table->string('password');
                $table->string('phone_number');
                $table->enum('role', ['user', 'admin']);
                $table->rememberToken();
                $table->timestamps();
            });
        }

        /**
         *  requires users table foreign keys
         * when a user's role = Admin an entry is made
         * for any user in the admin table their is only 1 entry
         */
        if (!Schema::hasTable('admin_table')) {
            Schema::create('admin_table', function (Blueprint $table) {
                $table->increments('admin_id');
                $table->unsignedInteger('user_id');
                $table->timestamps();
                $table->foreign('user_id')->references('user_id')->on('users_table')->onDelete('cascade');
            });
        }

        /**
         * does not require foreign keys
         */
        if (!Schema::hasTable('products_table')) {
            Schema::create('products_table', function (Blueprint $table) {
                $table->increments('product_id');
                $table->string('category_name');
                $table->string('product_name')->unique();
                $table->integer('price');
                $table->text('description');
                $table->timestamps();
            });
        }

        /**
         *  requires product and admin tables first for foreign keys
         * There is 1 products entry for each inventory row
         */
        if (!Schema::hasTable('inventory_table')) {
            Schema::create('inventory_table', function (Blueprint $table) {
                $table->increments('inventory_id');
                $table->unsignedInteger('product_id');
                $table->unsignedInteger('admin_id');
                $table->integer('stock_level')->default(0);
                $table->timestamps();
                // Threshold will send notification if stock level is exceedingly low
                //$table->integer('threshold_level')->default(0)->nullable();
                $table->foreign('product_id')->references('product_id')->on('products_table')->onDelete('cascade');
                $table->foreign('admin_id')->references('admin_id')->on('admin_table')->onDelete('cascade');
            });
        }

        /**
         * requires admin and user and order detail table for foreign keys
         * requires rule for many OrderDetails, and Total_price column is sum of all associated Price_of_order's
         */
        if (!Schema::hasTable('orders_table')) {
            Schema::create('orders_table', function (Blueprint $table) {
                $table->increments('order_id');
                $table->decimal('total_price', 10, 0)->default(0);
                $table->timestamp('order_time');
                $table->unsignedInteger('admin_id');
                $table->unsignedInteger('user_id');
                $table->foreign('admin_id')->references('admin_id')->on('admin_table')->onDelete('cascade');
                $table->foreign('user_id')->references('user_id')->on('users_table')->onDelete('cascade');
                $table->enum('status', ['pending', 'shipped', 'delivered', 'cancelled'])->default('pending');
                // payment currently out of scope
                // $table->enum('payment_type', ['Visa', 'MasterCard', 'PayPal']);
                $table->timestamps();
            });
        }

        /**
         * requires products and orders tables for foreign keys
         * */
        if (!Schema::hasTable('orders_details_table')) {
            Schema::create('orders_details_table', function (Blueprint $table) {
                $table->increments('orders_details_id');
                $table->unsignedInteger('order_id');
                $table->unsignedInteger('product_id');
                $table->integer('quantity');
                $table->decimal('price_of_order', 10, 0);
                $table->timestamps();
                $table->foreign('order_id')->references('order_id')->on('orders_table')->onDelete('cascade');
                $table->foreign('product_id')->references('product_id')->on('products_table')->onDelete('cascade');
            });
        }

        /**
         * requires user and products_table for foreign keys
         */
        if (!Schema::hasTable('reviews_table')) {
            Schema::create('reviews_table', function (Blueprint $table) {
                $table->increments('review_id');
                $table->unsignedInteger('user_id');
                $table->unsignedInteger('product_id');
                // remember to make Rating a drop down of 0 to 5
                $table->integer('rating')->default(5);
                $table->text('review_text')->default('');
                $table->timestamp('review_date');
                // does not run seeding without more timestamps
                $table->timestamps();
                $table->foreign('user_id')->references('user_id')->on('users_table')->onDelete('cascade');
                $table->foreign('product_id')->references('product_id')->on('products_table')->onDelete('cascade');
            });
        }

        /**
         * requires order, order, product, user and admin tables for foreign keys
         * */
        // not using since no return page
    //     if (!Schema::hasTable('returns_table')) {
    //         Schema::create('returns_table', function (Blueprint $table) {
    //             $table->increments('return_id');
    //             $table->unsignedInteger('order_id');
    //             $table->unsignedInteger('product_id');
    //             $table->unsignedInteger('user_id');
    //             $table->unsignedInteger('admin_id');
    //             $table->text('return_reason');
    //             $table->enum('return_status', ['pending', 'approved', 'rejected', 'completed', 'refunded', 'cancelled'])->default('pending');
    //             // not timestamp since Return_date will be a chosen date to return by
    //             $table->dateTime('return_date');
    //             $table->timestamps();
    //             $table->foreign('user_id')->references('user_id')->on('users_table')->onDelete('cascade');
    //             $table->foreign('product_id')->references('product_id')->on('products_table')->onDelete('cascade');
    //             $table->foreign('order_id')->references('order_id')->on('orders_table')->onDelete('cascade');
    //             $table->foreign('admin_id')->references('admin_id')->on('admin_table')->onDelete('cascade');
    //         });
    //     }

        if (!Schema::hasTable('cart_table')) {
            Schema::create('cart_table', function (Blueprint $table) {
                $table->increments('basket_id');
                $table->unsignedInteger('user_id');
                $table->unsignedInteger('product_id');
                // remember to make Rating a drop down of 0 to 5
                $table->integer('quantity');
                $table->integer('price');
                $table->foreign('user_id')->references('user_id')->on('users_table')->onDelete('cascade');
                $table->foreign('product_id')->references('product_id')->on('products_table')->onDelete('cascade');
                $table->timestamps();
        });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users_table');
        Schema::dropIfExists('admin_table');
        Schema::dropIfExists('products_table');
        Schema::dropIfExists('inventory_table');
        Schema::dropIfExists('orders_table');
        Schema::dropIfExists('orders_details_table');
        Schema::dropIfExists('reviews_table');
        Schema::dropIfExists('returns_table');
        Schema::dropIfExists('cart_table');
    }
};