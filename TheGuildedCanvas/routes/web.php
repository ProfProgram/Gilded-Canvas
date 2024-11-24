<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/home', function () {
    return view('home');
});

Route::get('/sign-up', function () {
    return view('sign-up');
});

Route::get('/sign-in', function () {
    return view('sign-in');
});

Route::get('/contact-us', function () {
    return view('contact-us');
});

Route::get('/basket', function () {
    return view('basket');
});

Route::get('/product', function () {
    return view('product');
});

Route::get('/payment', function () {
    return view('payment');
});

Route::get('/review', function () {
    return view('review');
});

Route::post('/register', [UserController::class, 'register']);
