<?php

use App\Http\Controllers\Auth\AccountDeletionController;
use App\Http\Controllers\Auth\PasswordResetController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\SocialiteController;
use App\Http\Controllers\VendorController;
use App\Http\Controllers\WebSettingController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/dashboard');

Route::middleware(['guest'])->prefix('auth')->group(function () {
    Route::get('login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('login', [AuthController::class, 'login'])->middleware('throttle:login')->name('login.post');
    Route::get('register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('register', [AuthController::class, 'register'])->name('register.post');

    Route::get('/forgot-password', [PasswordResetController::class, 'showLinkRequestForm'])->name('password.request');
    Route::post('/forgot-password', [PasswordResetController::class, 'sendResetLinkEmail'])->name('password.email');
    Route::get('/reset-password/{token}', [PasswordResetController::class, 'showResetForm'])->name('password.reset');
    Route::post('/reset-password', [PasswordResetController::class, 'reset'])->name('password.update');

});

Route::middleware(['auth'])->group(function () {
    Route::post('auth/logout', [AuthController::class, 'logout'])->name('logout');

    // Delete account (request email)
    Route::post('/profile/deletion/request', [AccountDeletionController::class, 'requestDeletion'])
        ->name('account.deletion.request');

    // Link dari email (tidak perlu auth; pakai signed + token DB)
    Route::get('/profile/deletion/confirm', [AccountDeletionController::class, 'confirm'])
        ->name('account.deletion.confirm')->middleware('signed');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('email/verify', [AuthController::class, 'verifyEmail'])->name('verification.notice');
});
Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
    return redirect()->route('dashboard.index')->with('status', 'Email verified successfully!');
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();
    return back()->with('status', 'Verification link sent!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');

Route::prefix('auth')->group(function () {
    Route::get('google/redirect', [SocialiteController::class, 'redirect'])->name('google.redirect');
    Route::get('google/callback', [SocialiteController::class, 'callback'])->name('google.callback');
    Route::get('google/choose-role', [SocialiteController::class, 'chooseRole'])->name('google.chooseRole');
    Route::post('google/complete-register', [SocialiteController::class, 'completeRegister'])->name('google.completeRegister');
});


Route::get('/dashboard/orders-stats', [DashboardController::class, 'getOrdersStats'])->name('dashboard.orders.stats');

Route::middleware(['auth'])
    ->prefix('dashboard')
    ->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard.index');
        Route::resource('categories', CategoryController::class);
        Route::resource('products', ProductController::class);
        Route::resource('orders', OrderController::class);
        Route::put('orders/{order}/status', [OrderController::class, 'updateStatus'])->name('orders.updateStatus');
        Route::resource('vendors', VendorController::class);
        Route::resource('customers', CustomerController::class);
        Route::get('profile', [ProfileController::class, 'index'])->name('profile.index');
        Route::get('profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::put('profile/update', [ProfileController::class, 'update'])->name('profile.update');
        Route::get('settings', [WebSettingController::class, 'index'])->name('settings.index');
        Route::post('settings', [WebSettingController::class, 'update'])->name('settings.update');
    });