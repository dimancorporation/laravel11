<?php

use App\Http\Controllers\BitrixController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Middleware\FirstAuthMiddleware;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/test', [BitrixController::class, 'getUserList'])->name('bitrix');

Route::middleware(['auth', 'verified', 'first.auth'])
    ->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        Route::get('/status-descriptions', function () {
            return view('status-descriptions');
        })->name('status-descriptions');

        Route::get('/list-documents', function () {
            return view('list-documents');
        })->name('list-documents');

        Route::get('/payment', function () {
            return view('payment');
        })->name('payment');

        Route::get('/settings', function () {
            return view('settings');
        })->name('settings');
    });

Route::middleware(['auth', FirstAuthMiddleware::class])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
