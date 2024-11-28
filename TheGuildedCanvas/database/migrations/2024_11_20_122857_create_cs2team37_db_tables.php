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
        /**
         * does not require foreign keys
         */
        Schema::create('Users Table', function (Blueprint $table) {
            $table->increments('User_id');
            $table->string('Name');
            $table->string('Email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('Password');
            $table->string('Phone_number');
            $table->enum('Role', ['User', 'Admin']);
            $table->rememberToken();
            $table->timestamps();
        });

        /**
         *  requires users table foreign keys
         * when a user's role = Admin an entry is made
         * for any user in the admin table their is only 1 entry
         */ 
        Schema::create('Admin Table', function (Blueprint $table) {
            $table->increments('Admin_id');
            $table->unsignedInteger('User_id');
            $table->timestamps();
            $table->foreign('User_id')->references('User_id')->on('Users Table')->onDelete('cascade');
        });

        /** 
         * does not require foreign keys
         */
        Schema::create('Products Table', function (Blueprint $table) {
            $table->increments('Product_id');
            $table->string('Category_name');
            $table->string('Product_name');
            $table->text('Description');
            $table->timestamps();
        });

        /**
         *  requires product and admin tables first for foreign keys
         * There is 1 products entry for each inventory row
         */
        Schema::create('Inventory Table', function (Blueprint $table) {
            $table->increments('Inventory_id');
            $table->unsignedInteger('Product_id');
            $table->unsignedInteger('Admin_id');
            $table->integer('Stock_in')->default(0);
            $table->integer('Stock_out')->default(0);
            $table->integer('Stock_level')->default(0);
            $table->timestamps();
            // Threshold will send notification if stock level is exceedingly low 
            //$table->integer('Threshold_level')->default(0)->nullable();
            $table->foreign('Product_id')->references('Product_id')->on('Products Table')->onDelete('cascade');
            $table->foreign('Admin_id')->references('Admin_id')->on('Admin Table')->onDelete('cascade');
        });

        /**
         * requires admin and user and order detail table for foreign keys
         * requires rule for many OrderDetails, and Total_price column is sum of all associated Price_of_order's
         */
        Schema::create('Orders Table', function (Blueprint $table) {
            $table->increments('Order_id');
            $table->decimal('Total_price', 10, 0)->default(0);
            $table->timestamp('Order_time');
            $table->unsignedInteger('Admin_id');
            $table->unsignedInteger('User_id');
            $table->timestamps();
            $table->foreign('Admin_id')->references('Admin_id')->on('Admin Table')->onDelete('cascade');
            $table->foreign('User_id')->references('User_id')->on('Users Table')->onDelete('cascade');
            $table->enum('Status', ['Pending','Shipped','Delivered','Cancelled'])->default('Pending');
            // payment currently out of scope
            // $table->enum('Payment_type', ['Visa', 'MasterCard', 'PayPal']);
        });

        /**
         * requires products and orders tables for foreign keys
         * */
        Schema::create('Orders Details Table', function (Blueprint $table) {
            $table->increments('Orders_details_id');
            $table->unsignedInteger('Order_id');
            $table->unsignedInteger('Product_id');
            $table->integer('Quantity');
            $table->decimal('Price_of_order', 10, 0);
            $table->timestamps();
            $table->foreign('Order_id')->references('Order_id')->on('Orders Table')->onDelete('cascade');
            $table->foreign('Product_id')->references('Product_id')->on('Products Table')->onDelete('cascade');
        });

        /**
         * requires user and Products Table for foreign keys
         */
        Schema::create('Reviews Table', function (Blueprint $table) {
            $table->increments('Review_id');
            $table->unsignedInteger('User_id');
            $table->unsignedInteger('Product_id');
            // remember to make Rating a drop down of 0 to 5
            $table->integer('Rating')->default(5);
            $table->text('Review_text')->default('');
            $table->timestamp('Review_date');
            $table->timestamps();
            $table->foreign('User_id')->references('User_id')->on('Users Table')->onDelete('cascade');
            $table->foreign('Product_id')->references('Product_id')->on('Products Table')->onDelete('cascade');
        });
        
        /**
         * requires order, order, product, user and admin tables for foreign keys
         * */
        Schema::create('Returns Table', function (Blueprint $table) {
            $table->increments('Return_id');
            $table->unsignedInteger('Order_id');
            $table->unsignedInteger('Product_id');
            $table->unsignedInteger('User_id');
            $table->unsignedInteger('Admin_id');
            $table->text('Return_reason');
            $table->enum('Return_status', ['Pending','Approved','Rejected','Completed','Refunded','Cancelled'])->default('Pending');
            // not timestamp since Return_date will be a chosen date to return by
            $table->dateTime('Return_date');
            $table->timestamps();
            $table->foreign('User_id')->references('User_id')->on('Users Table')->onDelete('cascade');
            $table->foreign('Product_id')->references('Product_id')->on('Products Table')->onDelete('cascade');
            $table->foreign('Order_id')->references('Order_id')->on('Orders Table')->onDelete('cascade');
            $table->foreign('Admin_id')->references('Admin_id')->on('Admin Table')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('Users Table');
        Schema::dropIfExists('Admin Table');
        Schema::dropIfExists('Products Table');
        Schema::dropIfExists('Inventory Table');
        Schema::dropIfExists('Orders Table');
        Schema::dropIfExists('Orders Details Table');
        Schema::dropIfExists('Reviews Table');
        Schema::dropIfExists('Returns Table');
    }
};
