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
    private string $paymentSuccessStatus = 'CONFIRMED';
    protected ServiceBuilder $serviceBuilder;
    protected IncomingWebhookInvoiceService $incomingWebhookInvoiceService;

    public function __construct(ServiceBuilder $serviceBuilder, IncomingWebhookInvoiceService $incomingWebhookInvoiceService)
    {
        $this->serviceBuilder = $serviceBuilder;
        $this->incomingWebhookInvoiceService = $incomingWebhookInvoiceService;
    }
    /*
    тестовые данные карты
    4300 0000 0000 0777
    12/30
    111
     */
    public function handle(Request $request): ResponseFactory|Application|Response
    {
        $path = 'logs/log.txt';
        $data = $request->all();
        $paymentService = new PaymentService($data);
        Log::info('Онлайн касса прислала данные о платеже:', $data);
        Storage::put($path, json_encode($data, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
        $payment = $paymentService->findPayment();
        $user = $paymentService->findUser();
        if (!$payment) {
            $paymentService->createPayment($user);
            return response('OK', 200)->header('Content-Type', 'text/plain');
        }
        $paymentService->updateExistingPayment($payment);
//        if ($payment->status === 'CONFIRMED') {
        if ($payment->status === $this->paymentSuccessStatus) {
            $additionalInfo = $paymentService->generateAdditionalInfo($payment);
            $this->incomingWebhookInvoiceService->createInvoiceFromOnlinePayment($user, $payment, $additionalInfo);
            return response('OK', 200)->header('Content-Type', 'text/plain');
        }
        return response('OK', 200)->header('Content-Type', 'text/plain');
    }
}
