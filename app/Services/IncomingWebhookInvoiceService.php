<?php

namespace App\Services;

use App\Models\Invoice;
use App\Models\Payment;
use App\Models\PaymentMethod;
use App\Models\User;
use Bitrix24\SDK\Services\ServiceBuilder;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class IncomingWebhookInvoiceService
{
    protected ServiceBuilder $serviceBuilder;
    protected PaymentMethod $paymentMethod;
    protected SettingsService $settingsService;

    public function __construct(ServiceBuilder $serviceBuilder, PaymentMethod $paymentMethod, SettingsService $settingsService)
    {
        $this->serviceBuilder = $serviceBuilder;
        $this->paymentMethod = $paymentMethod;
        $this->settingsService = $settingsService;
    }

    public function isRequestFromWebhook(array $data): bool
    {
        $event = $data['event'];
        $domain = $data['auth']['domain'];
        $applicationToken = $data['auth']['application_token'];
        /* действия со счетами, которые перехватываем */
        $allowedEvents = ['ONCRMDYNAMICITEMADD', 'ONCRMDYNAMICITEMUPDATE', 'ONCRMDYNAMICITEMDELETE'];
        /* обрабатываем только ENTITY_TYPE_ID = 31, тк это сущность "Счета" */
        $entityTypeId = $data['data']['FIELDS']['ENTITY_TYPE_ID'];
        $path = 'logs/log.txt';
        Log::info('Bitrix24 webhook received isRequestFromWebhook:', $data);
//        $bitrixWebhookDomain = env('BITRIX_WEBHOOK_DOMAIN');
//        $bitrixWebhookInvoiceToken = env('BITRIX_WEBHOOK_INVOICE_TOKEN');
//        $bitrixInvoiceEntityTypeId = env('BITRIX_INVOICE_ENTITY_TYPE_ID');
        $bitrixWebhookDomain = $this->settingsService->getValueByCode('BITRIX_WEBHOOK_DOMAIN');
        $bitrixWebhookInvoiceToken = $this->settingsService->getValueByCode('BITRIX_WEBHOOK_INVOICE_TOKEN');
        $bitrixInvoiceEntityTypeId = $this->settingsService->getValueByCode('BITRIX_INVOICE_ENTITY_TYPE_ID');
        Log::info('isRequestFromWebhook1:', ['qwe' => 'qwe1', 'q1' => $bitrixWebhookDomain, 'q2' => $bitrixWebhookInvoiceToken, 'q3' => $bitrixInvoiceEntityTypeId]);
        if (!in_array($event, $allowedEvents) || $domain !== $bitrixWebhookDomain || $applicationToken !== $bitrixWebhookInvoiceToken || $entityTypeId !== $bitrixInvoiceEntityTypeId) {
            Storage::put($path, 'false');
            Log::info('isRequestFromWebhook2:', ['qwe' => 'qwe2']);
            return false;
        }
        Storage::put($path, 'true');
        return true;
    }

    private function getInvoiceData(int $invoiceId): array
    {
        $invoiceFields = [
            'id',
            'ufCrm_SMART_INVOICE_1712111561782', /* тип оплаты */
            'ufCrm_SMART_INVOICE_1735207439444', /* служебное поле с json данными */
            'title',
            'opportunity',
            'isManualOpportunity',
            'currencyId',
            'createdTime',
            'updatedTime',
            'movedTime',
            'stageId',
            'previousStageId',
            'begindate',
            'closedate',
            'categoryId',
            'contactId'
        ];
        $filterFields = ['ID' => $invoiceId];
        /*
         * https://dev.1c-bitrix.ru/api_d7/bitrix/crm/crm_owner_type/identifiers.php
         * для счетов entityTypeId = 31(хардкод от самого битрикс24)
         */
        //$bitrixInvoiceEntityTypeId = env('BITRIX_INVOICE_ENTITY_TYPE_ID');
        $bitrixInvoiceEntityTypeId = $this->settingsService->getValueByCode('BITRIX_INVOICE_ENTITY_TYPE_ID');
        /* получение списка счетов по айди контакта, вместо списка полей можно использовать ['*'] */
        $invoiceData = iterator_to_array($this->serviceBuilder->getCRMScope()->item()->list(
            $bitrixInvoiceEntityTypeId,
            [],
            $filterFields,
            $invoiceFields
        )->getItems()[0]->getIterator())[0];

        $path = 'logs/log.txt';
        Storage::put($path, json_encode($invoiceData, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
        Log::info('Bitrix24 webhook2 received:', $invoiceData);
        return $invoiceData;
    }

    /*
    тестовые данные карты
    4300 0000 0000 0777
    12/30
    111
     */
    public function createOrUpdateInvoice(int $invoiceId): bool
    {
        $invoiceData = $this->getInvoiceData($invoiceId);
        $paymentId = $invoiceData['ufCrm_SMART_INVOICE_1712111561782'];
        $paymentTypeName = $this->getPaymentTypeName($paymentId);
        $commonFields = $this->getInvoiceCommonFields($paymentId, $invoiceData, $paymentTypeName);
        $invoice = Invoice::where('b24_invoice_id', $invoiceId);
        if (!$invoice->exists()) {
            $fields = array_merge(['b24_invoice_id' => $invoiceData['id']], $commonFields);
            if (isset($invoiceData['ufCrm_SMART_INVOICE_1735207439444']) && $invoiceData['ufCrm_SMART_INVOICE_1735207439444']) {
                $additionalFieldB24 = json_decode($invoiceData['ufCrm_SMART_INVOICE_1735207439444'], true); //UF_CRM_SMART_INVOICE_1735207439444 -> ufCrm_SMART_INVOICE_1735207439444
                $payment_id = $additionalFieldB24['payment_id']; //айди из таблицы payments
                $PaymentId = $additionalFieldB24['PaymentId']; //данные от онлайн кассы
                $OrderId = $additionalFieldB24['OrderId']; //данные от онлайн кассы
                $fields = array_merge(['payment_id' => $payment_id, 'comments' => 'Оплата через онлайн кассу'], $fields);

                /* ======================= */
                $path = 'logs/log.txt';
                $existingContent = Storage::get($path);
                $newContent = $existingContent . "\n" . json_encode($fields, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
                Storage::put($path, $newContent);
                Log::info('Онлайн касса прислала данные о платеже:', $fields);
                /* ======================= */

                $payment = Payment::where('order_id', $OrderId)
                                  ->where('payment_id', $PaymentId);

                /* для invoice обновляем payment_id */
                $invoice = Invoice::create($fields);
                $invoice->payment_id = $payment->first()->id;
                $invoice->save();
                /* для payment обновляем b24_invoice_id */
                $result = $payment->update(['b24_invoice_id' => $invoice->id]);
            } else {
                $result = Invoice::create($fields);
            }
        } else {
            $result = $invoice->update($commonFields);
        }

        return (bool)$result;
    }

    private function getInvoiceCommonFields(int $paymentId, array $invoiceData, string $paymentTypeName): array
    {
        return [
            'b24_payment_type_id' => $paymentId,
            'b24_payment_type_name' => $paymentTypeName,
            'title' => $invoiceData['title'],
            'created_time' => $invoiceData['createdTime'],
            'updated_time' => $invoiceData['updatedTime'],
            'moved_time' => $invoiceData['movedTime'],
            'category_id' => $invoiceData['categoryId'],
            'stage_id' => $invoiceData['stageId'],
            'previous_stage_id' => $invoiceData['previousStageId'],
            'begin_date' => $invoiceData['begindate'],
            'closed_date' => $invoiceData['closedate'],
            'contact_id' => $invoiceData['contactId'],
            'opportunity' => $invoiceData['opportunity'],
            'is_manual_opportunity' => $invoiceData['isManualOpportunity'],
            'currency_id' => $invoiceData['currencyId'],
        ];
    }

    /**
     * код поля в битрикс24 = ufCrm_SMART_INVOICE_1712111561782
     * @throws Exception
     */
    private function getPaymentTypeName(int $paymentId): string
    {
        return $this->paymentMethod->getPaymentName($paymentId);
    }

    public function createInvoiceFromOnlinePayment(User $user, Payment $payment, array $additionalInfo): void
    {
        //'На расчетный счет компании'
        $paymentMethodCode = PaymentMethod::where('b24_payment_type_name', 'На расчетный счет компании')
                                          ->value('b24_payment_type_id');

        $bitrixInvoiceEntityTypeId = env('BITRIX_INVOICE_ENTITY_TYPE_ID');
        $invoice = $this->serviceBuilder->getCRMScope()->item()->add($bitrixInvoiceEntityTypeId, [
            'title' => 'Счёт #' . $payment->payment_id,
            'contactId' => $user->contact_id,
            'currencyId' => 'RUB',
            'opportunity' => $payment->amount,
            "stageId" => 'DT31_2:P',
            'ufCrm_SMART_INVOICE_1712111561782' => $paymentMethodCode,
            'parentId2' => $user->contact_id,
            'ufCrm_SMART_INVOICE_1735207439444' => json_encode($additionalInfo),
            'comments' => 'Оплата через онлайн кассу',
        ]);

        $invoiceData = iterator_to_array($invoice->item()->getIterator());
        $payment->update(['b24_invoice_id' => $invoiceData['id']]);
    }
}
