<?php

namespace App\Http\Controllers;

use App\Models\B24Documents;
use App\Models\User;
use App\Models\B24Status;
use App\Services\IncomingWebhookDealService;
use Bitrix24\SDK\Services\ServiceBuilder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class WebhookController3 extends Controller
{
    protected ServiceBuilder $serviceBuilder;
    protected IncomingWebhookDealService $incomingWebhookDealService;
    public function __construct(ServiceBuilder $serviceBuilder, IncomingWebhookDealService $incomingWebhookDealService)
    {
        $this->serviceBuilder = $serviceBuilder;
        $this->incomingWebhookDealService = $incomingWebhookDealService;
    }
    public function handle(Request $request): JsonResponse
    {
        $path = 'logs/log.txt';
        $data = $request->all();
        Log::info('Онлайн касса прислала данные о платеже:', $data);
        Storage::put($path, json_encode($data, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
        return response()->json(['status' => 'success'], 200);
    }
}
