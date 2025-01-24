<?php

namespace App\Http\Controllers;

use App\Services\IncomingWebhookInvoiceService;
use Bitrix24\SDK\Services\ServiceBuilder;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
// контроллер для обработки исходящего вебхука по счетам
class WebhookInvoiceController extends Controller
{
    protected ServiceBuilder $serviceBuilder;
    protected IncomingWebhookInvoiceService $incomingWebhookInvoiceService;
    public function __construct(ServiceBuilder $serviceBuilder, IncomingWebhookInvoiceService $incomingWebhookInvoiceService)
    {
        $this->serviceBuilder = $serviceBuilder;
        $this->incomingWebhookInvoiceService = $incomingWebhookInvoiceService;
    }

    /**
     * @throws Exception
     */
    public function handle(Request $request): JsonResponse
    {
        $path = 'logs/log.txt';
        $data = $request->all();
        $invoiceId = $data['data']['FIELDS']['ID'];
        Storage::put($path, json_encode($data, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
        Log::info('Bitrix24 webhook2 received:', $data);

        $isRequestFromWebhook = $this->incomingWebhookInvoiceService->isRequestFromWebhook($data);
        if (!$isRequestFromWebhook) {
            return response()->json([
                'status' => 'error',
                'message' => 'Bad Request'
            ], 400);
        }

        if ($data['event'] === 'ONCRMDYNAMICITEMDELETE') {
            $this->incomingWebhookInvoiceService->deleteInvoice($invoiceId);
            return response()->json(['status' => 'success'], 200);
        }

        if ($data['event'] === 'ONCRMDYNAMICITEMUPDATE') {
            sleep(3);
        }

        $this->incomingWebhookInvoiceService->createOrUpdateInvoice($invoiceId);
        return response()->json(['status' => 'success'], 200);
    }
}
