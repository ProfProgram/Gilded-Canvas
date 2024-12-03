<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\paymentController;
use App\Http\Controllers\OrdersController;


Route::get('/home', function () {
    return view('home');
});

Route::get('/sign-up', function () {
    return view('sign-up');
});
// SIGN IN PAGE (LOGIN)
Route::get('/sign-in', function () {
    return view('sign-in');
});

// SIGN UP PAGE
Route::get('/contact-us', function () {
    return view('contact-us');
});

Route::get('/basket', function () {
    return view('basket');
});

// PREVIOUS ORDERS
Route::get('/previous-orders', [OrdersController::class, 'index']);

Route::get('/product', function () {
    return view('product');
});

// PAYMENT ROUTES
Route::get('/payment', [paymentController::class, 'index']);
Route::post('/payment', [paymentController::class, 'store']);

// REVIEW ROUTES
Route::get('/review', [ReviewController::class, 'index']);
Route::post('/review', [ReviewController::class, 'store']);

// REMOVE THE ALERT MESSAGE
Route::post('/close-alert', function () {Session::forget('status'); return redirect()->back();})->name('close-alert');     
