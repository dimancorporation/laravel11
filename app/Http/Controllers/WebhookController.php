<?php

namespace App\Http\Controllers;

use App\Services\IncomingWebhookDealService;
use Bitrix24\SDK\Services\ServiceBuilder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

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
        $data = $request->all();
        Log::info('Bitrix24 deal webhook received:', $data);

        $dealId = $data['data']['FIELDS']['ID'];
        if (!$this->incomingWebhookDealService->validateRequestData($data)) {
            Log::error('Invalid request data received. Missing required keys.');
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid request data.'
            ], 400);
        }

        $dealData = $this->incomingWebhookDealService->getDealData($dealId);
        Log::info('Received data by deal id:', $dealData);

        $isRequestFromWebhook = $this->incomingWebhookDealService->isRequestFromWebhook($data, $dealData);
        if (!$isRequestFromWebhook) {
            Log::error('Bad request from deal webhook.');
            return response()->json([
                'status' => 'error',
                'message' => 'Insufficient permissions.'
            ], 403);
        }

        $this->incomingWebhookDealService->createOrUpdateUser($dealId, $dealData);
        return response()->json(['status' => 'success'], 200);
    }
}
