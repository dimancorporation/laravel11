<?php

use App\Http\Controllers\WebhookController;
use App\Http\Controllers\WebhookPaymentController;
use App\Http\Controllers\WebhookInvoiceController;
use Illuminate\Support\Facades\Route;

Route::post('/webhook-deal', [WebhookController::class, 'handle'])->withoutMiddleware('csrf');
Route::post('/webhook-invoice', [WebhookInvoiceController::class, 'handle'])->withoutMiddleware('csrf');
Route::post('/webhook-payment', [WebhookPaymentController::class, 'handle'])->withoutMiddleware('csrf');
