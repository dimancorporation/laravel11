<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use App\Services\InvoiceService;
use App\Services\PaymentService;
use App\Services\SettingsService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PaymentController extends Controller
{
    protected InvoiceService $invoiceService;
    protected PaymentService $paymentService;
    protected SettingsService $settingsService;

    public function __construct(InvoiceService $invoiceService, PaymentService $paymentService, SettingsService $settingsService)
    {
        $this->invoiceService = $invoiceService;
        $this->paymentService = $paymentService;
        $this->settingsService = $settingsService;
    }
    public function index(Request $request): View
    {
        $user = $request->user();
//        $invoices = Invoice::where('contact_id', $user->contact_id)
//                           ->where('stage_id', 'DT31_2:P')
//                           ->get();
        /* статус в б24 оплаченного счета 'DT31_2:P', но может и меняться, например: 'DT31_3:P' */
//        $invoices = Invoice::where('contact_id', $user->contact_id)
//                           ->where('stage_id', 'like', '%:P') // Найдем все stage_id, заканчивающиеся на :P
//                           ->get();


        $paymentSettings = $this->settingsService->getPaymentSettings();
//        dump($paymentSettings);
//        $paymentData = $this->paymentService->getPaymentData();
//        $terminalKey = $paymentData['TERMINAL_KEY'];
//        $emailCompany = $paymentData['EmailCompany'];
        $invoices = $this->invoiceService->getUserInvoices($user);
        return view('payment', compact('invoices', 'user', 'paymentSettings'));
    }

    public function store(Request $request)
    {
        // -> создаем запись в таблице "payments"
        // -> далее отправляем платеж в онлайн кассу Т-Банка
        // -> далее приходит ответ от онлайн кассы
        // -> обновляем данные в таблице "payments"
        // -> создаем счет в битрикс24 (используем данные из оплаты Т-Банка - уникальную комбинацию для названия счета в битрикс24 Счет # + PaymentId/payment_id)
        // -> приходит ответ от битрикс24 о созданном счете
        // -> создаем запись в таблице "invoices", в поле title будет уникальное название Счет # + PaymentId/payment_id, далее по paymentId ищем запись в payments и связываем с таблицей invoices

        // "OrderId": "1735113428919",
        // "PaymentId": 5564265726,

        // нужно добавить в таблицу invoices доп поля PaymentId и OrderId
        //'{"PaymentId":5564265726,"OrderId":5564265726}'; - служебное поле в счетах "UF_CRM_SMART_INVOICE_1735207439444"

        // ---создаем запись в таблице "payments"
        // -> отправляем платеж в онлайн кассу Т-Банка
        // -> далее приходит ответ от онлайн кассы
        // -> создаем запись в таблице "payments"
//            "OrderId": "1735210644861",
//            "Success": true,
//            "Status": "AUTHORIZED",  -   "CONFIRMED"
//            "PaymentId": 5572530796,
//            "Amount": 99900,

        // ---обновляем данные в таблице "payments" - поле "status"
        // -> создаем счет в битрикс24 (используем данные из оплаты Т-Банка), в служебное поле битрикс24 "UF_CRM_SMART_INVOICE_1735207439444" пихаем json '{"PaymentId":5564265726,"OrderId":5564265726}'
        // -> приходит ответ от битрикс24 о созданном счете и далее по данным из ответа создаем запись в таблице "invoices", получаем id созданной записи
        // -> используя "payment_id" и "order_id" можем найти запись в таблице "payments" и обновляем поле b24_invoice_id айдишкой записи, полученной на предыдущем шаге

        // -> надо связать записи из таблиц "payments" и "invoices"



//        $user = User::where('email', '=', $request['email'])
//                    ->where('phone', '=', $request['phone'])
//                    ->first();
//        $b24_contact_id = $user->contact_id;
//        $b24_deal_id = $user->id_b24;

//        $invoice = Invoice::where('title', '=', 'Счёт #5564265726')
//                          ->where('contact_id', '=', $b24_contact_id)
//                          ->first();
//        $b24_invoice_id = $invoice->id; // айди записи из таблицы "invoices"


//        $payment = Payment::where('payment_id', $paymentId)->first();
//        if ($payment) {
//            $payment->update(['invoice_id' => $newInvoiceId]);
//        }

//        $payment = Payment::create([
//            'name' => $b24_contact_id,
//        ]);

        return response()->json(['message' => 'Данные успешно сохранены!'], 200);
    }
}
