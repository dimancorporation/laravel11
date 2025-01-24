<?php

use App\Http\Controllers\WebhookController;
use App\Http\Controllers\WebhookPaymentController;
use App\Http\Controllers\WebhookInvoiceController;
use Illuminate\Support\Facades\Route;

//для обновления-создания сделки
Route::post('/webhookdeal', [WebhookController::class, 'handle'])->withoutMiddleware('csrf');
//для работы со счетами
Route::post('/webhookinvoice', [WebhookInvoiceController::class, 'handle'])->withoutMiddleware('csrf');
//для работы с онлайн кассой
Route::post('/webhook-payment', [WebhookPaymentController::class, 'handle'])->withoutMiddleware('csrf');
