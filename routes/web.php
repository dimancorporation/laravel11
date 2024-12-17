<?php

use App\Http\Controllers\BitrixController;
use Illuminate\Support\Facades\Route;

Route::get('/test', [BitrixController::class, 'getUserList']);

Route::get('/', function () {
    return view('welcome');
});
