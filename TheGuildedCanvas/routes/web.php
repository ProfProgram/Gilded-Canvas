<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\homeController;
use App\Http\Controllers\IndivProductController;
use App\Http\Controllers\productListing;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\paymentController;
use App\Http\Controllers\OrdersController;
use App\Http\Controllers\ProductController;
use App\Mail\ResetPassword;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\UserController;
use App\Mail\TestMail;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Models\User;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\UserManagementController;



Auth::routes(['verify' => true]);

// Admin routes
Route::middleware('auth')->group(function () {
    // Inventory management routes
    Route::get('/admin/inventory', [InventoryController::class, 'index'])->name('admin.inventory');
    Route::put('/admin/inventory/{id}', [InventoryController::class, 'update'])->name('admin.inventory.update');
    Route::delete('/admin/inventory/{id}', [InventoryController::class, 'destroy'])->name('admin.inventory.destroy');
});
// Manager routes
Route::middleware('auth')->group(function () {
    Route::get('manager/users', [UserManagementController::class, 'index'])->name('manager.users');
    Route::put('manager/users/{id}', [UserManagementController::class, 'updateRole'])->name('manager.users.update');
    Route::delete('manager/users/{id}', [UserManagementController::class, 'destroy'])->name('manager.users.destroy');
});
// Handle email verification
Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
    return redirect()->route('home');
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::post('/email/resend', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();
    return back()->with('message', 'Verification link sent!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');

// Example route for mailing
Route::get('/test-mail', function ($name, $email) {
    Mail::to($email)->send(new TestMail($name, $email));
    return 'email sent successfully';
});

Route::get('/verify', [UserController::class, 'verifyEmail'])->name('email.verify');

Route::get('password/reset', [ForgotPasswordController::class, 'showForgotForm'])->name('password.request');
Route::post('password/email', [ForgotPasswordController::class, 'sendResetLink'])->name('password.email');
Route::get('password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('password/reset', [ResetPasswordController::class, 'resetPassword'])->name('password.update');


Route::get('/', [homeController::class, 'index']);

Route::get('/home', [homeController::class, 'index'])->name('home');
Route::get('/search', [homeController::class, 'search'])->name('home-search');

Route::get('/sign-up', function () {
    return view('sign-up');
});
// SIGN IN PAGE (LOGIN)
Route::get('/sign-in', function () {
    return view('sign-in');
})->name('sign-in');

// SIGN UP PAGE
Route::get('/contact-us', function () {
    return view('contact-us');
});

// BASKET PAGE
Route::get('/basket', [CartController::class, 'index'])->name('basket');
Route::get('delete/{id}', [CartController::class, 'delete'])->name('cart_delete');

Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
Route::post('/update-basket', [CartController::class, 'update'])->name('basket.update');


// PREVIOUS ORDERS
Route::get('/previous-orders', [OrdersController::class, 'index']);

// PRODUCT LISTINGS
Route::get('/product', [productListing::class, 'index'])->name('product.index');
Route::get('/prod-search', [productListing::class, 'search'])->name('product-search');

// INDIVIDUAL DYNAMIC PRODUCTS
// needs to be updated to be dynamic name in url
Route::get('/product/{productName}', [IndivProductController::class, 'index']);

// PAYMENT ROUTES
Route::get('/payment', [paymentController::class, 'index']);
Route::post('/payment', [paymentController::class, 'store']);

// REVIEW ROUTES
Route::get('/review', [ReviewController::class, 'index']);
Route::post('/review', [ReviewController::class, 'store']);

// REMOVE THE ALERT MESSAGE
Route::post('/close-alert', function () {Session::forget('status'); return redirect()->back();})->name('close-alert');

// ABOUT US
Route::get('/about-us', function () {
    return view('about-us');
})->name('about');

// CONTACT US
Route::get('/contact-us', function () {
    return view('contact-us');
})->name('contact');
