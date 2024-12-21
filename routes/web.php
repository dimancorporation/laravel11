<?php

use App\Http\Controllers\B24DocFieldController;
use App\Http\Controllers\B24UserFieldController;
use App\Http\Controllers\BitrixController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DocumentsController;
use App\Http\Controllers\OfferAgreement;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SettingsController;
use App\Http\Middleware\FirstAuthMiddleware;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/test', [BitrixController::class, 'getUserList'])->name('bitrix');

Route::middleware(['auth', 'verified', 'first.auth', 'web'])
    ->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        Route::get('/status-descriptions', function () {
            return view('status-descriptions');
        })->name('status-descriptions');

        Route::get('/documents', [DocumentsController::class, 'index'])->name('documents');

        Route::get('/payment', function () {
            return view('payment');
        })->name('payment');

        Route::get('/offer-agreement', function () {
            return view('offer-agreement');
        })->name('offer-agreement');

        Route::get('/settings', [SettingsController::class, 'index'])->name('settings');

        Route::get('/debtor', function () {
            return view('debtor');
        })->name('debtor');

        Route::post('/save-user-fields', [B24UserFieldController::class, 'store'])->name('save.user.fields');
        Route::post('/save-doc-fields', [B24DocFieldController::class, 'store'])->name('save.doc.fields');
        Route::post('/upload-offer-agreement', [OfferAgreement::class, 'store'])->name('upload.offer.agreement');
    });

Route::middleware(['auth', 'first.auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
