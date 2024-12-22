<?php

namespace App\Http\Controllers;

use Bitrix24\SDK\Services\ServiceBuilder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class WebhookController2 extends Controller
{
    protected ServiceBuilder $serviceBuilder;
    public function __construct(ServiceBuilder $serviceBuilder)
    {
        $this->serviceBuilder = $serviceBuilder;
    }
    public function handle(Request $request): JsonResponse
    {
        $path = 'logs/log.txt';
        // Получаем данные из запроса
        $data = $request->all();
        Storage::put($path, json_encode($data, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
        Log::info('Bitrix24 webhook2 received:', $data);
        return response()->json(['status' => 'success'], 200);
    }
}
