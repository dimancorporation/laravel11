<?php

namespace App\Http\Controllers;

use App\Services\IncomingWebhookInvoiceService;
use App\Services\PaymentService;
use Bitrix24\SDK\Services\ServiceBuilder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Foundation\Application;
use Illuminate\Http\Response;

// обрабатываем данные от онлайн кассы
class WebhookPaymentController extends Controller
{
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

        $user = $this->paymentService->findUser($request);
        Log::info('Поиск пользователя завершен', [
            'user' => $user ? $user->id : 'не найден',
        ]);

        $payment = $this->paymentService->findPayment($request);
        Log::info('Поиск платежа завершен', [
            'payment' => $payment ? $payment->id : 'не найден',
        ]);

        if ($payment) {
            Log::info('Обработка существующего платежа', [
                'payment_id' => $payment->id,
                'user_id' => $user ? $user->id : 'не найден',
            ]);

            $this->processPaymentForUser($user, $payment, $data);
            return $this->sendOKResponse();
        }

        Log::info('Создание нового платежа');
        $this->paymentService->createPayment($request);

        return $this->sendOKResponse();
    }

    private function processPaymentForUser($user, $payment, $data): void
    {
        Log::info('Обновление платежа', [
            'payment_id' => $payment->id,
            'user_id' => $user ? $user->id : 'не найден',
            'data' => $data,
        ]);

        $this->paymentService->updateExistingPayment($payment, $data);

        if ($payment->status === $this->paymentConfirmedStatus) {
            Log::info('Платеж подтвержден', [
                'payment_id' => $payment->id,
                'user_id' => $user ? $user->id : 'не найден',
            ]);

            $additionalInfo = $this->paymentService->generateAdditionalInfo($payment);
            Log::info('Создание счета на основе онлайн-платежа', [
                'user_id' => $user ? $user->id : 'не найден',
                'payment_id' => $payment->id,
                'additional_info' => $additionalInfo,
            ]);

            $this->incomingWebhookInvoiceService->createInvoiceFromOnlinePayment($user, $payment, $additionalInfo);
        } else {
            Log::warning('Платеж не подтвержден', [
                'payment_id' => $payment->id,
                'status' => $payment->status,
            ]);
        }
    }

    private function sendOKResponse(): Response
    {
        return response('OK', 200)->header('Content-Type', 'text/plain');
    }
}
