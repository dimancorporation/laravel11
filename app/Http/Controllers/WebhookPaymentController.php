<?php

namespace App\Http\Controllers;

use App\Services\IncomingWebhookInvoiceService;
use App\Services\PaymentService;
use Bitrix24\SDK\Services\ServiceBuilder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Foundation\Application;
use Illuminate\Http\Response;

// обрабатываем данные от онлайн кассы
class WebhookPaymentController extends Controller
{
    private const LOG_FILE_PATH = 'logs/log.txt';
    private string $paymentConfirmedStatus = 'CONFIRMED';

    protected ServiceBuilder $serviceBuilder;
    protected IncomingWebhookInvoiceService $incomingWebhookInvoiceService;
    protected PaymentService $paymentService;

    public function __construct(
        ServiceBuilder $serviceBuilder,
        IncomingWebhookInvoiceService $incomingWebhookInvoiceService,
        PaymentService $paymentService
    ) {
        $this->serviceBuilder = $serviceBuilder;
        $this->incomingWebhookInvoiceService = $incomingWebhookInvoiceService;
        $this->paymentService = $paymentService;
    }

    public function handle(Request $request): ResponseFactory|Application|Response
    {
        $data = $request->all();

        // Event?
        Log::info('Онлайн касса прислала данные о платеже:', $data);
        Storage::put(self::LOG_FILE_PATH, json_encode($data, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));

        $user = $this->paymentService->findUser($request);
        $payment = $this->paymentService->findPayment($request);

        if ($payment) {
            $this->processPaymentForUser($user, $payment, $data);
            return $this->sendOKResponse();
        }

        $this->paymentService->createPayment($request);
        return $this->sendOKResponse();
    }

    private function processPaymentForUser($user, $payment, $data): void
    {
        $this->paymentService->updateExistingPayment($payment, $data);

        if ($payment->status === $this->paymentConfirmedStatus) {
            $additionalInfo = $this->paymentService->generateAdditionalInfo($payment);
            $this->incomingWebhookInvoiceService->createInvoiceFromOnlinePayment($user, $payment, $additionalInfo);
        }
    }

    private function sendOKResponse(): Response
    {
        return response('OK', 200)->header('Content-Type', 'text/plain');
    }
}
