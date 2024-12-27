<?php

namespace App\Http\Controllers;

use App\Models\Payment;
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

    public function handle(Request $request): ResponseFactory|Application|Response
    {
        $bitrixInvoiceEntityTypeId = env('BITRIX_INVOICE_ENTITY_TYPE_ID');
        $path = 'logs/log.txt';
        $data = $request->all();
        Log::info('Онлайн касса прислала данные о платеже:', $data);
        Storage::put($path, json_encode($data, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
        return response('OK', 200)->header('Content-Type', 'text/plain');

        $payment = Payment::where('order_id', '=', $data['OrderId'])
            ->where('payment_id', '=', $data['PaymentId'])
            ->first();
        if (!$payment->exists()) {
            $user = User::where('email', '=', $data['Data']['Email'])
                        ->where('phone', '=', $data['Data']['Phone'])
                        ->first();

            $paymentId = $data['PaymentId'];
            $orderId = $data['OrderId'];

            $paymentNew = Payment::create([
                'b24_deal_id' => $user->id_b24,
                'b24_contact_id' => $user->contact_id,
                'b24_invoice_id' => null,
                'order_id' => $orderId,
                'success' => $data['Success'],
                'status' => $data['Status'],
                'payment_id' => $paymentId,
                'amount' => $data['Amount'] / 100,
                'card_id' => $data['CardId'],
                'email' => $data['Data']['Email'],
                'name' => $data['Data']['Name'],
                'phone' => $data['Data']['Phone'],
                'source' => $data['Source'],
                'user_agent' => $data['Data']['user_agent'],
            ]);

            $additionalInfo = [
                'payment_id' => $paymentNew->id,
                'PaymentId' => $paymentId,
                'OrderId' => $orderId
            ];
            $additionalFieldB24 = json_encode($additionalInfo);

            $response = $this->serviceBuilder->getCRMScope()->item()->add($bitrixInvoiceEntityTypeId, [
                'title' => 'Счёт #'.$paymentId,
                'contactId' => $user->contact_id,
                'currencyId' => 'RUB',
                'opportunity' => $data['Amount'] / 100,
                "stageId" => $data['Status'] === 'CONFIRMED' ? 'DT31_3:P' : 'DT31_3:N',
                'ufCrm_SMART_INVOICE_1712111561782' => 271,
                'parentId2' => $user->contact_id,
                'UF_CRM_SMART_INVOICE_1735207439444' => $additionalFieldB24,
            ]);
            return response('OK', 200)->header('Content-Type', 'text/plain');
        }

        if ($payment->status !== 'CONFIRMED') {
            $paymentStatuses = [
                'REVERSING' => 'Мерчант запросил отмену авторизованного, но еще неподтвержденного платежа.',
                'PARTIAL_REVERSED' => 'Частичный возврат по авторизованному платежу завершился успешно.',
                'REVERSED' => 'Полный возврат по авторизованному платежу завершился успешно.',
                'REFUNDING' => 'Мерчант запросил отмену подтвержденного платежа.',
                'PARTIAL_REFUNDED' => 'Частичный возврат по подтвержденному платежу завершился успешно.',
                'REFUNDED' => 'Полный возврат по подтвержденному платежу завершился успешно.',
                'CANCELED' => 'Мерчант отменил платеж.',
                'DEADLINE_EXPIRED' => 'Клиент не завершил платеж в срок жизни ссылки на платежную форму PaymentURL или платеж не прошел проверку 3D-Secure в срок.',
                'REJECTED' => 'Банк отклонил платеж.',
                'AUTH_FAIL' => 'Платеж завершился ошибкой или не прошел проверку 3D-Secure.',
            ];
            $payment->update(['status' => $data['Status']]);
            if ($paymentStatuses[$data['Status']]) {
                $response = $this->serviceBuilder->getCRMScope()->item()->update($bitrixInvoiceEntityTypeId, $payment->b24_invoice_id, [
                    'comments' => $paymentStatuses[$data['Status']],
                ]);
                return response('OK', 200)->header('Content-Type', 'text/plain');
            }
            if ($data['Status'] === 'CONFIRMED') {
                $response = $this->serviceBuilder->getCRMScope()->item()->update($bitrixInvoiceEntityTypeId, $payment->b24_invoice_id, [
                    'stageId' => 'DT31_2:P',
                ]);
                return response('OK', 200)->header('Content-Type', 'text/plain');
            }
        }
        return response('OK', 200)->header('Content-Type', 'text/plain');
//        return response()->json(['status' => 'success'], 200);

//        {
//            "TerminalKey": "1734786275434DEMO",
//            "OrderId": "1735113428919",
//            "Success": true,
//            "Status": "REFUNDED",
//            "PaymentId": 5564265726,
//            "ErrorCode": "0",
//            "Amount": 20000,
//            "CardId": 512558103,
//            "Pan": "500000******0108",
//            "ExpDate": "1230",
//            "Token": "13e815caa14f2eab68b9ca50495ea9670d94ddcf5c45417c057b0b979bef2dd8",
//            "Data": {
//                "screenWidth": "2752",
//                "Email": "dimancorporation@yandex.ru",
//                "connection_type": "Widget2.0",
//                "screenHeight": "1152",
//                "Source": "cards",
//                "Name": "второй тест заказ",
//                "connection_type_pf": "true",
//                "isMIDSyncEnabled": "true",
//                "accept": "text\/html, image\/gif, image\/jpeg, *; q=.2, *\/*; q=.2",
//                "SEND_EMAIL": "Y",
//                "javaEnabled": "false",
//                "Phone": "9130621677",
//                "payAction": "3DS",
//                "order_id_unique_processed": "ignored",
//                "guid": "cb5f93ab-8c73-4baa-7956-aeabbd4cc101",
//                "colorDepth": "24",
//                "INFO_EMAIL": "dimancorporation@yandex.ru",
//                "user_agent": "Mozilla\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\/537.36 (KHTML, like Gecko) Chrome\/131.0.0.0 Safari\/537.36",
//                "REDIRECT": "false"
//            }
//        }

//        ПОЛЯ, КОТОРЫЕ СОХРАНЯТЬ В ТАБЛИЦУ БД
//        $data['OrderId'],
//        $data['Success'],
//        $data['Status'],
//        $data['PaymentId'],
//        $data['20000'],
//
//        $data['Data']['Email'],
//        $data['Data']['Name'],
//        $data['Data']['Phone'],
//        $data['Data']['order_id_unique_processed'],
//        $data['Data']['user_agent'],

        // статусы по платежам https://www.tbank.ru/kassa/dev/payments/#tag/Scenarii-oplaty-po-karte/Poluchenie-dannyh-o-platezhe
        $user = User::where('email', '=', $data['Data']['Email'])
            ->where('phone', '=', $data['Data']['Phone'])
            ->first();

//        $paymentStatuses = [
//            'REVERSING' => 'Мерчант запросил отмену авторизованного, но еще неподтвержденного платежа. Возврат обрабатывается MAPI и платежной системой.',
//            'PARTIAL_REVERSED' => 'Частичный возврат по авторизованному платежу завершился успешно.',
//            'REVERSED' => 'Полный возврат по авторизованному платежу завершился успешно.',
//            'REFUNDING' => 'Мерчант запросил отмену подтвержденного платежа. Возврат обрабатывается MAPI и платежной системой.',
//            'PARTIAL_REFUNDED' => 'Частичный возврат по подтвержденному платежу завершился успешно.',
//            'REFUNDED' => 'Полный возврат по подтвержденному платежу завершился успешно.',
//            'CANCELED' => 'Мерчант отменил платеж.',
//            'DEADLINE_EXPIRED' => '1. Клиент не завершил платеж в срок жизни ссылки на платежную форму PaymentURL. Этот срок мерчант передает в методе Init в параметре RedirectDueDate. 2. Платеж не прошел проверку 3D-Secure в срок.',
//            'REJECTED' => 'Банк отклонил платеж.',
//            'AUTH_FAIL' => 'Платеж завершился ошибкой или не прошел проверку 3D-Secure.',
//        ];
        $paymentStatuses = [
            'REVERSING' => 'Мерчант запросил отмену авторизованного, но еще неподтвержденного платежа.',
            'PARTIAL_REVERSED' => 'Частичный возврат по авторизованному платежу завершился успешно.',
            'REVERSED' => 'Полный возврат по авторизованному платежу завершился успешно.',
            'REFUNDING' => 'Мерчант запросил отмену подтвержденного платежа.',
            'PARTIAL_REFUNDED' => 'Частичный возврат по подтвержденному платежу завершился успешно.',
            'REFUNDED' => 'Полный возврат по подтвержденному платежу завершился успешно.',
            'CANCELED' => 'Мерчант отменил платеж.',
            'DEADLINE_EXPIRED' => 'Клиент не завершил платеж в срок жизни ссылки на платежную форму PaymentURL или платеж не прошел проверку 3D-Secure в срок.',
            'REJECTED' => 'Банк отклонил платеж.',
            'AUTH_FAIL' => 'Платеж завершился ошибкой или не прошел проверку 3D-Secure.',
        ];
        $currentPaymentStatus = $paymentStatuses[$data['Status']] ?? '';
        // создание счета по айди контакта
        $response = $this->serviceBuilder->getCRMScope()->item()->add($bitrixInvoiceEntityTypeId, [
            'title' => $data['Data']['Name'],
            'contactId' => $user->contact_id, // айди контакта
            'currencyId' => 'RUB',
            'opportunity' => $data['Amount'] / 100, // сумма платежа в копейках, делим на 100
//            "opened" => 'N',
            "stageId" => $data['Status'] === 'CONFIRMED' ? 'DT31_3:P' : 'DT31_3:N', // DT31_3:P - статус в битрикс24 ОПЛАЧЕН
            'ufCrm_SMART_INVOICE_1712111561782' => 271, // 269 - Наличные, 271 - На расчетный счет компании, 273 - Оплата на карту
            'parentId2' => $user->contact_id, // айди контакта
            'comments' => '', // комментарий к платежу - надо писать сообщение, если статус у платежа какой-либо из списка ниже
            /*
            REVERSING	     - Мерчант запросил отмену авторизованного, но еще неподтвержденного платежа. Возврат обрабатывается MAPI и платежной системой.
            PARTIAL_REVERSED - Частичный возврат по авторизованному платежу завершился успешно.
            REVERSED	     - Полный возврат по авторизованному платежу завершился успешно.
            REFUNDING	     - Мерчант запросил отмену подтвержденного платежа. Возврат обрабатывается MAPI и платежной системой.
            PARTIAL_REFUNDED - Частичный возврат по подтвержденному платежу завершился успешно.
            REFUNDED	     - Полный возврат по подтвержденному платежу завершился успешно.
            CANCELED	     - Мерчант отменил платеж.
            DEADLINE_EXPIRED - 1. Клиент не завершил платеж в срок жизни ссылки на платежную форму PaymentURL. Этот срок мерчант передает в методе Init в параметре RedirectDueDate. 2. Платеж не прошел проверку 3D-Secure в срок.
            REJECTED	     - Банк отклонил платеж.
            AUTH_FAIL	     - Платеж завершился ошибкой или не прошел проверку 3D-Secure.
             */
        ]);
        //REVERSING, REFUNDING, CANCELED, DEADLINE_EXPIRED, REJECTED, AUTH_FAIL

        /*
        На это уведомление важно правильно ответить (200-й код, в теле «OK»), иначе эйквайринг будет с упрямством коллектора слать одинаковые уведомления снова и снова.
        Для подстраховки от задваивания поступлений в базе данных рекомендую разрешить только уникальные комбинации Status + PaymentId.
        Либо по полю Token.
         */
        return response('OK', 200)->header('Content-Type', 'text/plain');
    }
}
