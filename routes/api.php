<?php

use App\Http\Controllers\WebhookController;
use App\Http\Controllers\WebhookPaymentController;
use App\Http\Controllers\WebhookInvoiceController;
use Illuminate\Support\Facades\Route;
/* todo переименовать /webhook, /webhook2, /webhook3 в более понятные */
//для обновления-создания сделки
//webhook-deal
Route::post('/webhook', [WebhookController::class, 'handle'])->withoutMiddleware('csrf');
//для работы со счетами
//webhook-invoice
Route::post('/webhook2', [WebhookInvoiceController::class, 'handle'])->withoutMiddleware('csrf');
//для работы с онлайн кассой
//webhook-payment
//https://ee5c-94-180-116-162.ngrok-free.app/api/webhook3
Route::post('/webhook3', [WebhookPaymentController::class, 'handle'])->withoutMiddleware('csrf');
