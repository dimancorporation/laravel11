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
        Log::info('Получены данные по вебхуку сделки:', $data);

        $dealId = $data['data']['FIELDS']['ID'];

        if (!$this->incomingWebhookDealService->validateRequestData($data)) {
            Log::error('Некорректные данные запроса. Отсутствуют необходимые данные.', [
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
        Log::info('Полученные данные по идентификатору сделки:', [
            'deal_id' => $dealId,
            'deal_data' => $dealDataCopy,
        ]);

        $isRequestFromWebhook = $this->incomingWebhookDealService->isRequestFromWebhook($data, $dealData);
        if (!$isRequestFromWebhook) {
            Log::error('Неверный запрос от вебхука сделки', [
                'deal_id' => $dealId,
                'request_data' => $data,
            ]);
            return response()->json([
                'status' => 'error',
                'message' => 'Insufficient permissions.'
            ], 403);
        }

        Log::info('Создание или обновление данных по айди сделки:', [
            'deal_id' => $dealId,
        ]);
        $this->incomingWebhookDealService->createOrUpdateUser($dealId, $dealData);

        return response()->json(['status' => 'success'], 200);
    }
}
