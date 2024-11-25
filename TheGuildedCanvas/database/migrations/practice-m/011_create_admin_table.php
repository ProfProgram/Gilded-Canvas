<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('admin_table', function (Blueprint $table) {
            $table->id('Admin_id');
            $table->string('Name');
            $table->string('Email');
            $table->string('Password');
            $table->string('Phone_number');
            $table->string('Role');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('admin_table');
    }
};