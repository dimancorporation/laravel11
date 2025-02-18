<?php

use App\Http\Controllers\WebhookController;
use App\Http\Controllers\WebhookPaymentController;
use App\Http\Controllers\WebhookInvoiceController;
use Illuminate\Support\Facades\Route;

Route::post('/webhook-deal', [WebhookController::class, 'handle'])->withoutMiddleware('csrf');
Route::post('/webhook-invoice', [WebhookInvoiceController::class, 'handle'])->withoutMiddleware('csrf');
Route::post('/webhook-payment', [WebhookPaymentController::class, 'handle'])->withoutMiddleware('csrf');

/*
Добавление элемента смарт-процесса (ONCRMDYNAMICITEMADD)
Изменение элемента смарт-процесса (ONCRMDYNAMICITEMUPDATE)
Удаление элемента смарт-процесса (ONCRMDYNAMICITEMDELETE)
https://qgl3te-94-180-116-162.nl.tuna.am/api/webhook-invoice

разделить добавление, изменение, удаление по разным урл-ам
https://qgl3te-94-180-116-162.nl.tuna.am/api/webhook-invoice-add
https://qgl3te-94-180-116-162.nl.tuna.am/api/webhook-invoice-update
https://qgl3te-94-180-116-162.nl.tuna.am/api/webhook-invoice-delete
*/
