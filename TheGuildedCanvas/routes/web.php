<?php 

use App\Http\Controllers\AccountController;
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
use App\Http\Controllers\ReturnController;
use App\Http\Controllers\CustomerController;


Auth::routes(['verify' => true]);

// Admin routes
Route::middleware('auth')->group(function () {
    // Inventory management routes
    Route::get('/admin/inventory', [InventoryController::class, 'index'])->name('admin.inventory');
    Route::get('/admin/inventory/search', [InventoryController::class, 'search'])->name('inventory-search');
    Route::put('/admin/inventory/{id}', [InventoryController::class, 'update'])->name('admin.inventory.update');
    Route::put('/admin/inventory/{id}/incoming', [InventoryController::class, 'updateIncoming'])->name('admin.inventory.update.incoming');
    Route::put('/admin/inventory/{id}/outgoing', [InventoryController::class, 'updateOutgoing'])->name('admin.inventory.update.outgoing');
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

// CONTACT US
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

// INDIVIDUAL DYNAMIC PRODUCTS
Route::get('/product/{productName}', [IndivProductController::class, 'index']);

// PAYMENT ROUTES
Route::get('/payment', [paymentController::class, 'index']);
Route::post('/payment', [paymentController::class, 'store']);

// REVIEW ROUTES
Route::get('/review', [ReviewController::class, 'index']);
Route::post('/review', [ReviewController::class, 'store']);

// REMOVE THE ALERT MESSAGE
Route::post('/close-alert', function () {Session::forget('status'); return redirect()->back();})->name('close-alert');
Route::get('/account/edit', [AccountController::class, 'openEditPage'])->name('account.editPage');
Route::get('/account', [AccountController::class, 'edit'])->name('account.edit');
Route::put('/account/update', [AccountController::class, 'update'])->name('account.update');
Route::post('/password/send-reset-link', [ForgotPasswordController::class, 'sendResetLinkForLoggedInUser'])
    ->name('password.authenticated-reset');

// ABOUT US
Route::get('/about-us', function () {
    return view('about-us');
})->name('about');

// CONTACT US
Route::get('/contact-us', function () {
    return view('contact-us');
})->name('contact');

// ADMIN ORDER MANAGEMENT
Route::get('/admin/orders', [OrdersController::class, 'manage'])->name('admin.orders');
Route::put('/admin/orders/{id}/update', [OrdersController::class, 'updateStatus'])->name('admin.orders.update');
Route::delete('/admin/orders/{id}/delete', [OrdersController::class, 'destroy'])->name('admin.orders.destroy');

// Customer Management
Route::middleware(['auth'])->group(function () {
    Route::get('/admin/customers', [CustomerController::class, 'manage'])->name('admin.customers');
    Route::post('/admin/customers/add', [CustomerController::class, 'store'])->name('admin.customers.add');
    Route::post('/admin/customers/store', [CustomerController::class, 'store'])->name('admin.customers.store');
    Route::put('/admin/customers/{id}/update', [CustomerController::class, 'update'])->name('admin.customers.update');
    Route::delete('/admin/customers/{id}/delete', [CustomerController::class, 'destroy'])->name('admin.customers.delete');
});

// Returns

// productAddButton

Route::get('/admin/product/create', [InventoryController::class, 'create'])->name('product.create');
Route::post('/admin/product/store', [InventoryController::class, 'store'])->name('product.store');


Route::put('/admin/product/update/{id}', [InventoryController::class, 'updateProduct'])->name('admin.product.update');
Route::delete('/admin/product/delete/{id}', [InventoryController::class, 'destroyProduct'])->name('admin.product.destroy');

Route::middleware(['auth'])->group(function () {
    Route::get('/admin/inventory', [InventoryController::class, 'index'])->name('admin.inventory');
    Route::get('/admin/product/create', [InventoryController::class, 'create'])->name('product.create');
    Route::post('/admin/product/store', [InventoryController::class, 'store'])->name('product.store');
    Route::put('/admin/product/update/{id}', [InventoryController::class, 'updateProduct'])->name('admin.product.update');
    Route::delete('/admin/product/delete/{id}', [InventoryController::class, 'destroyProduct'])->name('admin.product.destroy');
});
// Route to return form
Route::get('/return-request/{order_id}', [OrdersController::class, 'showReturnRequestForm'])
    ->middleware('auth') // Ensures only logged-in users can request a return
    ->name('return.request');

// Route to submit the return request (Handles form submission)
Route::post('/submit-return-request/{order_id}', [OrdersController::class, 'submitReturnRequest'])
    ->middleware('auth') // Prevents unauthorized return submissions
    ->name('return.submit');

// ADMIN DASHBOARD ROUTE
Route::get('/admin/dashboard', [InventoryController::class, 'dashboard'])->name('admin.dashboard');

// Route for admin managing returns
Route::middleware(['auth'])->group(function () {
    Route::get('/admin/returns', [ReturnController::class, 'manageReturns'])->name('admin.returns');
    Route::post('/admin/returns/update-status/{return_id}', [ReturnController::class, 'updateReturnStatus'])->name('admin.returns.updateStatus');
    Route::delete('/admin/returns/delete/{return_id}', [ReturnController::class, 'deleteReturn'])->name('admin.returns.delete');
});
use App\Http\Controllers\WebsiteReviewController;

// Group routes to ensure only authenticated users can access them
Route::middleware(['auth'])->group(function () {
    Route::get('/website-review', [WebsiteReviewController::class, 'create'])->name('website.review.create');
    Route::post('/website-review/store', [WebsiteReviewController::class, 'store'])->name('website.review.store');
    Route::get('/website-reviews', [WebsiteReviewController::class, 'index'])->name('website.reviews.index');
});


