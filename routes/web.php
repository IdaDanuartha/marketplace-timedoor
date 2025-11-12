<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SocialiteController;
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
});

Route::middleware(['auth'])->post('auth/logout', [AuthController::class, 'logout'])->name('logout');
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


Route::middleware(['auth'])
    ->prefix('dashboard')
    ->group(function () {
        Route::get('/', DashboardController::class)->name('dashboard.index');
        Route::resource('categories', CategoryController::class);
        Route::resource('products', ProductController::class);
        Route::resource('orders', OrderController::class);
        Route::resource('vendors', VendorController::class);
        Route::resource('customers', CustomerController::class);
        Route::get('profile', [ProfileController::class, 'index'])->name('profile.index');
        Route::get('profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::put('profile/update', [ProfileController::class, 'update'])->name('profile.update');
        Route::get('settings', [WebSettingController::class, 'index'])->name('settings.index');
        Route::post('settings', [WebSettingController::class, 'update'])->name('settings.update');
    });