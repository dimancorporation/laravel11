<?php

use App\Http\Controllers\WebhookController;
use App\Http\Controllers\WebhookController2;
use Illuminate\Support\Facades\Route;

//для обновления-создания сделки
Route::post('/webhook', [WebhookController::class, 'handle'])->withoutMiddleware('csrf');
//для работы со счетами
Route::post('/webhook2', [WebhookController2::class, 'handle'])->withoutMiddleware('csrf');
