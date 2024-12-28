<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\PaymentMethod;
use App\Models\User;
use App\Services\IncomingWebhookInvoiceService;
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
        $bitrixInvoiceEntityTypeId = env('BITRIX_INVOICE_ENTITY_TYPE_ID');
        $path = 'logs/log.txt';
        $data = $request->all();
        Log::info('Онлайн касса прислала данные о платеже:', $data);
        Storage::put($path, json_encode($data, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));

        $payment = Payment::where('order_id', $data['OrderId'])
                          ->where('payment_id', $data['PaymentId'])
                          ->first();

        $user = User::where('email', $data['Data']['Email'])
                    ->where('phone', '+7'.$data['Data']['Phone'])
                    ->first();

        if (!$payment) {
            Payment::create([
                'b24_deal_id' => $user->id_b24,
                'b24_contact_id' => $user->contact_id,
                'b24_invoice_id' => null,
                'order_id' => $data['OrderId'],
                'success' => $data['Success'],
                'status' => $data['Status'],
                'payment_id' => $data['PaymentId'],
                'amount' => $data['Amount'] / 100,
                'card_id' => $data['CardId'],
                'email' => $data['Data']['Email'],
                'name' => $data['Data']['Name'],
                'phone' => '+7'.$data['Data']['Phone'],
                'source' => $data['Data']['Source'],
                'user_agent' => $data['Data']['user_agent'],
            ]);
            return response('OK', 200)->header('Content-Type', 'text/plain');
        }

        $payment->update(['status' => $data['Status']]);
        if ($payment->status === 'CONFIRMED') {
            $additionalInfo = [
                'payment_id' => $payment->id,
                'PaymentId' => $payment->payment_id,
                'OrderId' => $payment->order_id
            ];

            //'На расчетный счет компании'
            $paymentMethodCode = PaymentMethod::where('b24_payment_type_name', 'На расчетный счет компании')
                                              ->value('b24_payment_type_id');

            $invoice = $this->serviceBuilder->getCRMScope()->item()->add($bitrixInvoiceEntityTypeId, [
                'title' => 'Счёт #'.$payment->payment_id,
                'contactId' => $user->contact_id,
                'currencyId' => 'RUB',
                'opportunity' => $data['Amount'] / 100,
                "stageId" => 'DT31_2:P',
                'ufCrm_SMART_INVOICE_1712111561782' => $paymentMethodCode,
                'parentId2' => $user->contact_id,
                'ufCrm_SMART_INVOICE_1735207439444' => json_encode($additionalInfo), //ufCrm_SMART_INVOICE_1735207439444 - UF_CRM_SMART_INVOICE_1735207439444
                'comments' => 'Оплата через онлайн кассу',
            ]);

            $invoiceData = iterator_to_array($invoice->item()->getIterator());
            $payment->update(['b24_invoice_id' => $invoiceData['id']]);
            return response('OK', 200)->header('Content-Type', 'text/plain');
        }
        return response('OK', 200)->header('Content-Type', 'text/plain');
    }
}
