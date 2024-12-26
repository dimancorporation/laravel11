<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\IncomingWebhookDealService;
use Bitrix24\SDK\Services\ServiceBuilder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Foundation\Application;
use Illuminate\Http\Response;

class WebhookController3 extends Controller
{
    protected ServiceBuilder $serviceBuilder;
    protected IncomingWebhookDealService $incomingWebhookDealService;

    public function __construct(ServiceBuilder $serviceBuilder, IncomingWebhookDealService $incomingWebhookDealService)
    {
        $this->serviceBuilder = $serviceBuilder;
        $this->incomingWebhookDealService = $incomingWebhookDealService;
    }

    public function handle(Request $request): ResponseFactory|Application|Response
    {
        $path = 'logs/log.txt';
        $data = $request->all();
        Log::info('Онлайн касса прислала данные о платеже:', $data);
        Storage::put($path, json_encode($data, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
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

        // ПОЛЯ, КОТОРЫЕ СОХРАНЯТЬ В ТАБЛИЦУ БД
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
//        $data['Data']['INFO_EMAIL'],
//        $data['Data']['user_agent'],

        // статусы по платежам https://www.tbank.ru/kassa/dev/payments/#tag/Scenarii-oplaty-po-karte/Poluchenie-dannyh-o-platezhe
        $user = User::where('email', '=', $data['Data']['Email'])
            ->where('phone', '=', $data['Data']['Phone'])
            ->first();

        $paymentStatuses = [
            'REVERSING' => 'Мерчант запросил отмену авторизованного, но еще неподтвержденного платежа. Возврат обрабатывается MAPI и платежной системой.',
            'PARTIAL_REVERSED' => 'Частичный возврат по авторизованному платежу завершился успешно.',
            'REVERSED' => 'Полный возврат по авторизованному платежу завершился успешно.',
            'REFUNDING' => 'Мерчант запросил отмену подтвержденного платежа. Возврат обрабатывается MAPI и платежной системой.',
            'PARTIAL_REFUNDED' => 'Частичный возврат по подтвержденному платежу завершился успешно.',
            'REFUNDED' => 'Полный возврат по подтвержденному платежу завершился успешно.',
            'CANCELED' => 'Мерчант отменил платеж.',
            'DEADLINE_EXPIRED' => '1. Клиент не завершил платеж в срок жизни ссылки на платежную форму PaymentURL. Этот срок мерчант передает в методе Init в параметре RedirectDueDate. 2. Платеж не прошел проверку 3D-Secure в срок.',
            'REJECTED' => 'Банк отклонил платеж.',
            'AUTH_FAIL' => 'Платеж завершился ошибкой или не прошел проверку 3D-Secure.',
        ];
        $currentPaymentStatus = $paymentStatuses[$data['Status']] ?? '';
        // создание счета по айди контакта
        $response = $this->serviceBuilder->getCRMScope()->item()->add(31, [
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
        dump($response);
        /*
        На это уведомление важно правильно ответить (200-й код, в теле «OK»), иначе эйквайринг будет с упрямством коллектора слать одинаковые уведомления снова и снова.
        Для подстраховки от задваивания поступлений в базе данных рекомендую разрешить только уникальные комбинации Status + PaymentId.
        Либо по полю Token.
         */
        return response()->json(['status' => 'OK'], 200);
    }
}
