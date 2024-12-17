<?php

use App\Services\Bitrix;
use Illuminate\Support\Facades\Route;

Route::get('/test', function (Bitrix $bitrix) {
    dump($bitrix->bitrix->getMainScope()->main()->getApplicationInfo()->applicationInfo());
});

Route::get('/', function () {
    return view('welcome');
});
