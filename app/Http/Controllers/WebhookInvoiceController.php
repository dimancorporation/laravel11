<?php

namespace App\Http\Controllers;

use App\Services\IncomingWebhookInvoiceService;
use App\Services\InvoiceService;
use Bitrix24\SDK\Services\ServiceBuilder;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class WebhookInvoiceController extends Controller
{
    protected ServiceBuilder $serviceBuilder;
    protected IncomingWebhookInvoiceService $incomingWebhookInvoiceService;
    protected InvoiceService $invoiceService;

    public function __construct(ServiceBuilder $serviceBuilder, IncomingWebhookInvoiceService $incomingWebhookInvoiceService, InvoiceService $invoiceService)
    {
        $this->serviceBuilder = $serviceBuilder;
        $this->incomingWebhookInvoiceService = $incomingWebhookInvoiceService;
        $this->invoiceService = $invoiceService;
    }

    /**
     * @throws Exception
     */
    public function handle(Request $request): JsonResponse
    {
        $data = $request->all();
        $invoiceId = $data['data']['FIELDS']['ID'];

        Log::info('Получены данные по вебхуку по счетам:', $data);

        $isRequestFromWebhook = $this->incomingWebhookInvoiceService->isRequestFromWebhook($data);
        Log::info('Проверка данных в запросе', [
            'is_webhook' => $isRequestFromWebhook,
        ]);

        if (!$isRequestFromWebhook) {
            Log::warning('Неверный запрос от вебхука', [
                'data' => $data,
            ]);
            return response()->json([
                'status' => 'error',
                'message' => 'Bad Request'
            ], 400);
        }

        if ($data['event'] === 'ONCRMDYNAMICITEMDELETE') {
            Log::info('Обработка события удаления счета', [
                'invoice_id' => $invoiceId,
            ]);
            $this->incomingWebhookInvoiceService->deleteInvoice($invoiceId);
            $this->invoiceService->updatePaidAmountInBitrix($invoiceId);
            return response()->json(['status' => 'success'], 200);
        }

        if ($data['event'] === 'ONCRMDYNAMICITEMUPDATE') {
            Log::info('Обработка события обновления счета', [
                'invoice_id' => $invoiceId,
            ]);
            sleep(3);
        }

        Log::info('Создание или обновление счета', [
            'invoice_id' => $invoiceId,
        ]);
        $this->incomingWebhookInvoiceService->createOrUpdateInvoice($invoiceId);

        return response()->json(['status' => 'success'], 200);
    }
}
