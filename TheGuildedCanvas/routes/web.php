<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ReviewController;

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

// REVIEW ROUTES
Route::get('/review', [ReviewController::class, 'index']);
Route::post('/review', [ReviewController::class, 'store']);

// REMOVE THE ALERT MESSAGE
Route::post('/close-alert', function () {Session::forget('status'); return redirect()->back();})->name('close-alert');     