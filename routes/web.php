<?php

use App\Http\Controllers\B24DocFieldController;
use App\Http\Controllers\B24StatusController;
use App\Http\Controllers\B24UserFieldController;
use App\Http\Controllers\BitrixController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DebtorController;
use App\Http\Controllers\DocumentsController;
use App\Http\Controllers\LogoController;
use App\Http\Controllers\OfferAgreement;
use App\Http\Controllers\PayInvoiceController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\ThemeController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

//Route::get('/test', [BitrixController::class, 'getUserList'])->name('bitrix');

// Секция для admin
Route::middleware(['auth', 'roles', 'web'])->group(function () {
    Route::get('/settings', [SettingsController::class, 'index'])->name('settings');

    //Http/Middleware/RoleRedirectMiddleware.php
    Route::post('/save-user-fields', [B24UserFieldController::class, 'store'])->name('save.user.fields');
    Route::post('/save-doc-fields', [B24DocFieldController::class, 'store'])->name('save.doc.fields');
    Route::post('/save-setting-fields', [SettingsController::class, 'store'])->name('save.setting.fields');
    Route::post('/save-b24statuses-fields', [B24StatusController::class, 'store'])->name('save.b24statuses.fields');
    Route::post('/save-debtor-text', [SettingsController::class, 'debtor'])->name('save.debtor.text');
    Route::post('/upload-offer-agreement', [OfferAgreement::class, 'store'])->name('upload.offer.agreement');
    Route::post('/theme', [ThemeController::class, 'update'])->name('admin.theme.update');
    Route::post('/logo', [LogoController::class, 'update'])->name('admin.logo.update');
});

// Секция должников
Route::middleware(['auth', 'roles'])->group(function () {
    Route::get('/debtor', [DebtorController::class, 'store'])->name('debtor');
});

// Секция для user
Route::middleware(['auth', 'verified', 'first.auth', 'web', 'roles'])
    ->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        Route::get('/status-descriptions', function () {
            return view('status-descriptions');
        })->name('status-descriptions');

        Route::get('/documents', [DocumentsController::class, 'index'])->name('documents');

        Route::get('/payment', [PaymentController::class, 'index'])->name('payment');

        Route::get('/pay-invoice', [PayInvoiceController::class, 'index'])->name('pay-invoice');

        Route::get('/offer-agreement', function () {
            return view('offer-agreement');
        })->name('offer-agreement');
    });

Route::middleware(['auth', 'first.auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
