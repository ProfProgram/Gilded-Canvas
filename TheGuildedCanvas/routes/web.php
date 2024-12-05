X<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Mail\TestMail;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;


Auth::routes(['verify' => true]);

Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
    return redirect('/home');
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::post('/email/resend', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();
    return back()->with('message', 'Verification link sent!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');

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


//Auth::routes(['verify' => true]);

Route::post('/register', [UserController::class, 'register']);

//Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/test-mail', function ($name,$email) {
    Mail::to($email)->send(new TestMail($name,$email));

    return 'email sent successfully';
});

Route::get('/verify', [UserController::class, 'verifyEmail'])->name('email.verify');

//Route::get('/test-mail', function ($name,$email) {
//    Mail::to($email)->send(new TestMail($name,$email));
//
//    return 'email sent successfully';
//});
