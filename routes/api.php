<?php

use App\Http\Controllers\WebhookController;
use App\Http\Controllers\WebhookController3;
use App\Http\Controllers\WebhookInvoiceController;
use Illuminate\Support\Facades\Route;

//для обновления-создания сделки
Route::post('/webhook', [WebhookController::class, 'handle'])->withoutMiddleware('csrf');
//для работы со счетами
Route::post('/webhook2', [WebhookInvoiceController::class, 'handle'])->withoutMiddleware('csrf');
//для работы с онлайн кассой
//https://ee5c-94-180-116-162.ngrok-free.app/api/webhook3
Route::post('/webhook3', [WebhookController3::class, 'handle'])->withoutMiddleware('csrf');
