<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LanguageController;

use App\Http\Controllers\AuthController;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('lang/{locale}', [LanguageController::class, 'switchLanguage'])->name('lang.switch');

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::get('/forgot-password', [AuthController::class, 'showForgotPassword'])->name('password.request');
Route::post('/forgot-password', [AuthController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('/reset-password/{token}', [AuthController::class, 'showResetForm'])->name('password.reset');
Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('password.update');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/order/{order}/receipt', function (\App\Models\Order $order) {
    return view('order-receipt', ['receiptOrder' => $order]);
})->name('order.receipt')->middleware('signed');
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::middleware([\App\Http\Middleware\OwnerTimeoutMiddleware::class])->group(function () {
        Route::get('/admin/owners', function () {
        return view('admin.owners');
    })->name('admin.owners');

    Route::get('/admin/health', function () {
        return view('admin.health');
    })->name('admin.health');

    Route::get('/owner/menu', function () {
        return view('owner.menu');
    })->name('owner.menu');

    Route::get('/owner/branches', function () {
        return view('owner.branches');
    })->name('owner.branches');

        Route::get('/owner/reports', function () {
            return view('owner.reports');
        })->name('owner.reports');
        
        Route::get('/owner/item-sales', function () {
            return view('owner.item-sales');
        })->name('owner.item_sales');
    });
});
