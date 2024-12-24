<?php

use App\Http\Controllers\WebhookController;
use App\Http\Controllers\WebhookInvoiceController;
use Illuminate\Support\Facades\Route;

//для обновления-создания сделки
Route::post('/webhook', [WebhookController::class, 'handle'])->withoutMiddleware('csrf');
//для работы со счетами
Route::post('/webhook2', [WebhookInvoiceController::class, 'handle'])->withoutMiddleware('csrf');
