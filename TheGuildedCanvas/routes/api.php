
<?php

use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Middleware\CheckAbilities;


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::middleware(['auth:sanctum', 'check_abilities:admin'])->group(function () {
    //Route::get('/admin/dashboard', [AdminController::class, 'dashboard']);
    // Other admin-specific routes
});

Route::middleware(['auth:sanctum', 'check_abilities:user'])->group(function () {
    //Route::get('/user/profile', [UserController::class, 'profile']);
    // Other user-specific routes
});


Route::post('/password/email', [ForgotPasswordController::class, 'sendResetLink'])->name('password.email');


Route::get('/home', [ProductController::class, 'index'])->name('home');
Route::delete('/users/{id}', [UserController::class, 'destroy'])->middleware('auth:sanctum');
Route::put('/users/{id}', [UserController::class, 'update'])->middleware('auth:sanctum');
Route::post('/logout', [LoginController::class, 'logout'])->middleware('auth:sanctum');
Route::post('/sign-up', [UserController::class, 'register'])->middleware('throttle:10,1')->name('register');
Route::post('/sign-in', [LoginController::class, 'login'])->middleware('throttle:10,1')->name('login');
Route::get('/product-carousel', [ProductController::class, 'getCarouselData']);
Route::get('/product/filter-by-genre', [ProductController::class, 'filterByGenre']);
Route::get('/product/filter-by-price', [ProductController::class, 'filterByPrice']);
Route::get('/product/search', [ProductController::class, 'searchProducts']);
Route::get('/product/featured', [ProductController::class, 'getFeatured']);
