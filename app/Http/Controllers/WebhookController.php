<?php

namespace App\Http\Controllers;

use App\Services\IncomingWebhookDealService;
use Bitrix24\SDK\Services\ServiceBuilder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class WebhookController extends Controller
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
        Log::info('Bitrix24 deal webhook received:', $data);
        Storage::put($path, json_encode($data, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));

        $dealId = $data['data']['FIELDS']['ID'];
        $dealData = $this->incomingWebhookDealService->getDealData($dealId);

        Log::info('dealData received:', $dealData);
        Storage::put($path, json_encode($dealData, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));

        $isRequestFromWebhook = $this->incomingWebhookDealService->isRequestFromWebhook($data, $dealData);
        if (!$isRequestFromWebhook) {
            return response()->json([
                'status' => 'error',
                'message' => 'Insufficient permissions to create account'
            ], 403);
        }

        $this->incomingWebhookDealService->createOrUpdateUser($dealId, $dealData);

        Storage::put($path, json_encode($dealData, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
        return response()->json(['status' => 'success'], 200);
    }
}
