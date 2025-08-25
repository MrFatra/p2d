<?php

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\Auth\ChangePassword;
use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\Auth\OTPController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\CheckHistoryController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

// Route::get('/login', [LoginController::class, 'index'])->name('login.index');
// Route::post('/login', [LoginController::class, 'login'])
//     ->name('login')
//     ->middleware('throttle:5,1');

// Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Route::get('/forgot-password', [ForgotPasswordController::class, 'index'])->name('password.index');
// Route::post('/forgot-password', [ForgotPasswordController::class, 'sendEmail'])->name('password.send-email');

// Route::get('/change-password', [ChangePassword::class, 'index'])->name('password.change.index');
// Route::post('/change-password', [ChangePassword::class, 'changePassword'])->name('password.change');

Route::get('/', [LandingPageController::class, 'index'])->name('landing.page');

Route::get('/articles', [ArticleController::class, 'index'])->name('articles.index');
Route::get('/articles/{slug}', [ArticleController::class, 'show'])->name('articles.show');

// Route::prefix('/otp')->group(function () {
//     Route::get('/', [OTPController::class, 'index'])->name('otp.index');
//     Route::post('/verify', [OTPController::class, 'verifyOtp'])
//         ->name('otp.verify')
//         ->middleware('throttle:5,1');
//     Route::post('/resend', [OTPController::class, 'resendOtp'])
//         ->name('otp.resend')
//         ->middleware('otp.throttle');
// });

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware('auth')->name('resident.dashboard');

Route::middleware(['auth'])->group(function () {
    Route::get('/check-history', [CheckHistoryController::class, 'index'])
        ->name('check-history');
});
