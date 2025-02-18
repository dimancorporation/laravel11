<?php

namespace App\Http\Controllers;

use App\Services\IncomingWebhookDealService;
use Bitrix24\SDK\Services\ServiceBuilder;
use Exception;
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

    /**
     * @throws Exception
     */
    public function handle(Request $request): JsonResponse
    {
        $data = $request->all();
        Log::info('Bitrix24 deal webhook received:', $data);

        $dealId = $data['data']['FIELDS']['ID'];

        if (!$this->incomingWebhookDealService->validateRequestData($data)) {
            Log::error('Invalid request data received. Missing required keys.', [
                'received_data' => $data,
            ]);
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid request data.'
            ], 400);
        }

        $dealData = $this->incomingWebhookDealService->getDealData($dealId);
        $dealDataCopy = [];
        foreach ($dealData as $key => $value) {
            if ($key !== 'userPassword') {
                $dealDataCopy[$key] = $value;
            }
        }
        Log::info('Received data by deal id:', [
            'deal_id' => $dealId,
            'deal_data' => $dealDataCopy,
        ]);

        $isRequestFromWebhook = $this->incomingWebhookDealService->isRequestFromWebhook($data, $dealData);
        if (!$isRequestFromWebhook) {
            Log::error('Bad request from deal webhook.', [
                'deal_id' => $dealId,
                'request_data' => $data,
            ]);
            return response()->json([
                'status' => 'error',
                'message' => 'Insufficient permissions.'
            ], 403);
        }

        Log::info('Creating or updating user for deal id:', [
            'deal_id' => $dealId,
        ]);
        $this->incomingWebhookDealService->createOrUpdateUser($dealId, $dealData);

        Log::info('Successfully processed deal webhook for deal id:', [
            'deal_id' => $dealId,
        ]);

        return response()->json(['status' => 'success'], 200);
    }
}
