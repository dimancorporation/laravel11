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
    private string $paymentType = 'На расчетный счет компании';
    protected ServiceBuilder $serviceBuilder;
    protected PaymentMethod $paymentMethod;
    protected SettingsService $settingsService;
    protected InvoiceService $invoiceService;

    public function __construct(ServiceBuilder $serviceBuilder, PaymentMethod $paymentMethod, SettingsService $settingsService, InvoiceService $invoiceService)
    {
        $this->serviceBuilder = $serviceBuilder;
        $this->paymentMethod = $paymentMethod;
        $this->settingsService = $settingsService;
        $this->invoiceService = $invoiceService;
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
        Log::info('Проверка данных в запросе, поступившем через вебхук по счетам:', $data);
        $bitrixWebhookDomain = $this->settingsService->getValueByCode('BITRIX_WEBHOOK_DOMAIN');
        $bitrixWebhookInvoiceToken = $this->settingsService->getValueByCode('BITRIX_WEBHOOK_INVOICE_TOKEN');
        $bitrixInvoiceEntityTypeId = $this->settingsService->getValueByCode('BITRIX_INVOICE_ENTITY_TYPE_ID');
        if (!in_array($event, $allowedEvents) || $domain !== $bitrixWebhookDomain || $applicationToken !== $bitrixWebhookInvoiceToken || $entityTypeId !== $bitrixInvoiceEntityTypeId) {
            Storage::put($path, 'false');
            return false;
        }
        Storage::put($path, 'true');
        return true;
    }

    private function getInvoiceData(int $invoiceId): array
    {
        $additionalPaymentInfo = $this->settingsService->getValueByCode('ADDITIONAL_PAYMENT_INFO');
        $paymentType = $this->settingsService->getValueByCode('PAYMENT_TYPE');
        $invoiceFields = [
            'id',
            $paymentType, /* тип оплаты, таблица Settings */
            $additionalPaymentInfo, /* служебное поле с json данными, таблица Settings */
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
        Log::info('Получены данные по счету:', $invoiceData);
        return $invoiceData;
    }

    /*
    тестовые данные карты
    4300 0000 0000 0777
    12/30
    111
     */
    /**
     * @throws Exception
     */
    public function createOrUpdateInvoice(int $invoiceId): bool
    {
        $result = null;
        Log::info('Начинаем создание или обновление счета.', ['invoice_id' => $invoiceId]);

        $invoiceData = $this->getInvoiceData($invoiceId);
        Log::info('Получены данные счета:', ['invoice_data' => $invoiceData]);

        $paymentType = $this->settingsService->getValueByCode('PAYMENT_TYPE');
        $paymentId = $invoiceData[$paymentType];

        if ($paymentId === null) {
            $paymentTypeMessage = 'Тип оплаты не найден, ставим первый тип оплаты';
            $paymentMethodFirst = PaymentMethod::first();
            $paymentId = $paymentMethodFirst->b24_payment_type_id;
            $paymentTypeName = $paymentMethodFirst->b24_payment_type_name;
        } else {
            $paymentTypeMessage = 'Тип оплаты найден';
            $paymentTypeName = $this->getPaymentTypeName($paymentId);
        }
        Log::info('Тип оплаты счета:', [
            'payment_type_message' => $paymentTypeMessage,
            'payment_id' => $paymentId,
            'payment_type_name' => $paymentTypeName
        ]);
        $commonFields = $this->getInvoiceCommonFields($paymentId, $invoiceData, $paymentTypeName);
        Log::info('Общие поля счета:', [
            'common_fields' => $commonFields
        ]);
        $invoiceQuery = Invoice::where('b24_invoice_id', $invoiceId);
        if (!$invoiceQuery->exists()) {
            Log::info('Счет не существует, создается новый.', ['invoice_id' => $invoiceId]);

            $fields = array_merge(['b24_invoice_id' => $invoiceData['id']], $commonFields);
            $additionalPaymentInfo = $this->settingsService->getValueByCode('ADDITIONAL_PAYMENT_INFO');

            if (isset($invoiceData[$additionalPaymentInfo]) && $invoiceData[$additionalPaymentInfo]) {
                $additionalFieldB24 = json_decode($invoiceData[$additionalPaymentInfo], true);
                $payment_id = $additionalFieldB24['payment_id']; // ID из таблицы payments
                $PaymentId = $additionalFieldB24['PaymentId']; // Данные от онлайн кассы
                $OrderId = $additionalFieldB24['OrderId']; // Данные от онлайн кассы

                Log::info('Дополнительная информация о платеже найдена, обрабатываем платеж.', [
                    'payment_id' => $payment_id,
                    'PaymentId' => $PaymentId,
                    'OrderId' => $OrderId,
                ]);

                $fields = array_merge(['payment_id' => $payment_id, 'comments' => 'Оплата через онлайн кассу'], $fields);

                $payment = Payment::where('order_id', $OrderId)
                    ->where('payment_id', $PaymentId);

                // для invoice обновляем payment_id
                try {
                    $invoice = Invoice::create($fields);
                    Log::info('Счет успешно создан.', ['invoice' => $invoice]);
                    $this->invoiceService->updatePaidAmountInBitrix($invoice->id);

                    if ($payment->exists()) {
                        $invoice->payment_id = $payment->first()->id;
                        $invoice->save();
                        Log::info('ID платежа обновлен для счета.', [
                            'invoice_id' => $invoice->id,
                            'payment_id' => $invoice->payment_id,
                        ]);
                    } else {
                        Log::warning('Запись о платеже не найдена для данного OrderId и PaymentId.', [
                            'OrderId' => $OrderId,
                            'PaymentId' => $PaymentId,
                        ]);
                    }

                    // для payment обновляем b24_invoice_id
                    $result = $payment->update(['b24_invoice_id' => $invoice->id]);
                    $this->invoiceService->updatePaidAmountInBitrix($invoice->id);
                } catch (Exception $e) {
                    Log::error('Ошибка при создании счета или обновлении платежа.', [
                        'error_message' => $e->getMessage(),
                        'invoice_data' => $fields,
                    ]);
                    return false;
                }
            } else {
                Log::info('Дополнительная информация о платеже не найдена, создаем счет без нее.');
                try {
                    $invoice = Invoice::create($fields);
                    Log::info('Счет успешно создан без дополнительной информации о платеже.', ['fields' => $fields]);
                    $this->invoiceService->updatePaidAmountInBitrix($invoice->id);
                } catch (Exception $e) {
                    Log::error('Ошибка при создании счета без дополнительной информации о платеже.', [
                        'error_message' => $e->getMessage(),
                        'fields' => $fields,
                    ]);
                    return false;
                }
            }
        } else {
            Log::info('Счет существует, обновляем его.', ['invoice_id' => $invoiceId]);
            try {
                $invoiceQuery = Invoice::where('b24_invoice_id', $invoiceId);
                $result = $invoiceQuery->update($commonFields);
                Log::info('Счет успешно обновлен.', ['invoice_id' => $invoiceId]);

                $this->invoiceService->updatePaidAmountInBitrix($invoiceId);
            } catch (Exception $e) {
                Log::error('Ошибка при обновлении счета.', [
                    'error_message' => $e->getMessage(),
                    'invoice_id' => $invoiceId,
                ]);
                return false;
            }
        }

        return (bool)$result;
    }

    //попытка разбить громоздкий метод createOrUpdateInvoice на мелкие
    /*
        public function createOrUpdateInvoice(int $invoiceId): bool
        {
            Log::info('Начинаем создание или обновление счета.', ['invoice_id' => $invoiceId]);

            $invoiceData = $this->getInvoiceData($invoiceId);
            Log::info('Получены данные счета:', ['invoice_data' => $invoiceData]);

            $paymentId = $this->getPaymentId($invoiceData);
            $paymentTypeName = $this->getPaymentTypeName($paymentId);

            $commonFields = $this->getInvoiceCommonFields($paymentId, $invoiceData, $paymentTypeName);
            Log::info('Общие поля счета:', ['common_fields' => $commonFields]);

            return $this->createOrUpdateInvoiceRecord($invoiceId, $invoiceData, $commonFields);
        }

        private function getPaymentId(array $invoiceData)
        {
            $paymentType = $this->settingsService->getValueByCode('PAYMENT_TYPE');
            $paymentId = $invoiceData[$paymentType];

            if ($paymentId === null) {
                Log::info('Тип оплаты не найден, ставим первый тип оплаты');
                $paymentMethodFirst = PaymentMethod::first();
                return $paymentMethodFirst->b24_payment_type_id;
            } else {
                Log::info('Тип оплаты найден');
                return $paymentId;
            }
        }

        private function createOrUpdateInvoiceRecord(int $invoiceId, array $invoiceData, array $commonFields): bool
        {
            $invoiceQuery = Invoice::where('b24_invoice_id', $invoiceId);

            if (!$invoiceQuery->exists()) {
                Log::info('Счет не существует, создается новый.', ['invoice_id' => $invoiceId]);

                return $this->createNewInvoice($invoiceData, $commonFields);
            } else {
                Log::info('Счет уже существует, обновляем данные.', ['invoice_id' => $invoiceId]);
                // Здесь можно добавить логику обновления существующего счета
            }

            return false; // Если счет существует, возвращаем false
        }

        private function createNewInvoice(array $invoiceData, array $commonFields): bool
        {
            $fields = array_merge(['b24_invoice_id' => $invoiceData['id']], $commonFields);
            $additionalPaymentInfo = $this->settingsService->getValueByCode('ADDITIONAL_PAYMENT_INFO');

            if (isset($invoiceData[$additionalPaymentInfo]) && $invoiceData[$additionalPaymentInfo]) {
                return $this->processAdditionalPaymentInfo($fields, json_decode($invoiceData[$additionalPaymentInfo], true));
            } else {
                Log::warning('Дополнительная информация о платеже отсутствует.');
                // Создаем счет без дополнительных данных
                Invoice::create($fields);
                Log::info('Счет успешно создан без дополнительной информации о платеже.', ['fields' => $fields]);

                return true;
            }
        }

        private function processAdditionalPaymentInfo(array &$fields, array $additionalFieldB24): bool
        {
            Log::info('Дополнительная информация о платеже найдена, обрабатываем платеж.', [
                'payment_id' => $additionalFieldB24['payment_id'],
                'PaymentId' => $additionalFieldB24['PaymentId'],
                'OrderId' => $additionalFieldB24['OrderId'],
            ]);

            // Обработка дополнительных данных
            $fields = array_merge(['payment_id' => $additionalFieldB24['payment_id'], 'comments' => 'Оплата через онлайн кассу'], $fields);

            // Проверка существования платежа
            $payment = Payment::where('order_id', $additionalFieldB24['OrderId'])
                              ->where('payment_id', $additionalFieldB24['PaymentId']);

            try {
                $invoice = Invoice::create($fields);
                Log::info('Счет успешно создан.', ['invoice' => $invoice]);

                if ($payment->exists()) {
                    $invoice->payment_id = $payment->first()->id;
                    $invoice->save();
                    Log::info('ID платежа обновлен для счета.', [
                        'invoice_id' => $invoice->id,
                        'payment_id' => $invoice->payment_id,
                    ]);

                    $result = $payment->update(['b24_invoice_id' => $invoice->id]);
                    Log::info('ID счета обновлен для платежа.', [
                        'result' => $result,
                        'payment_id' => $payment->id,
                        'invoice_id' => $invoice->id,
                    ]);
                } else {
                    Log::warning('Запись о платеже не найдена для данного OrderId и PaymentId.', [
                        'OrderId' => $additionalFieldB24['OrderId'],
                        'PaymentId' => $additionalFieldB24['PaymentId'],
                    ]);
                }

                return true;
            } catch (Exception $e) {
                Log::error('Ошибка при создании счета.', ['exception' => $e]);
                return false;
            }
        }
    */

    public function deleteInvoice(int $invoiceId): void
    {
        if (Invoice::where('b24_invoice_id', $invoiceId)->exists()) {
            Invoice::where('b24_invoice_id', $invoiceId)->delete();
        }
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
        $paymentMethodCode = PaymentMethod::where('b24_payment_type_name', $this->paymentType)
                                          ->value('b24_payment_type_id');

        $bitrixInvoiceEntityTypeId = $this->settingsService->getValueByCode('BITRIX_INVOICE_ENTITY_TYPE_ID');
        $successInvoiceStage = $this->settingsService->getValueByCode('SUCCESS_INVOICE_STAGE');
        $additionalPaymentInfo = $this->settingsService->getValueByCode('ADDITIONAL_PAYMENT_INFO');
        $paymentType = $this->settingsService->getValueByCode('PAYMENT_TYPE');
        $invoice = $this->serviceBuilder->getCRMScope()->item()->add($bitrixInvoiceEntityTypeId, [
            'title' => 'Счёт #' . $payment->order_id,
            'contactId' => $user->contact_id,
            'currencyId' => 'RUB',
            'opportunity' => $payment->amount,
            'stageId' => $successInvoiceStage,
            $paymentType => $paymentMethodCode,
            'parentId2' => $user->id_b24,
            $additionalPaymentInfo => json_encode($additionalInfo),
            'comments' => 'Оплата через онлайн кассу от ' . $user->name,
        ]);

        $invoiceData = iterator_to_array($invoice->item()->getIterator());
        $payment->update(['b24_invoice_id' => $invoiceData['id']]);
    }
}
