<?php

namespace App\Services;

use App\Models\Invoice;
use App\Models\Setting;
use App\Models\User;
use Bitrix24\SDK\Services\ServiceBuilder;
use Exception;
use Illuminate\Support\Facades\Log;

class InvoiceService
{
    protected ServiceBuilder $serviceBuilder;

    public function __construct(ServiceBuilder $serviceBuilder)
    {
        $this->serviceBuilder = $serviceBuilder;
    }

    public function getUserInvoices($user)
    {
        $successInvoiceStage = Setting::getValueByCode('SUCCESS_INVOICE_STAGE');
        if ($successInvoiceStage === null) {
            Log::warning('Не удалось получить значение SUCCESS_INVOICE_STAGE из таблицы настроек.');
            return collect();
        }

        return Invoice::where('contact_id', $user->contact_id)
                      ->where('stage_id', '=', $successInvoiceStage)
                      ->orderBy('updated_at', 'desc')
                      ->get();
    }

    /**
     * Обновляет сумму оплаченных счетов в Битрикс24
     *
     * @param int $invoiceId ID счета
     * @return void
     */
    public function updatePaidAmountInBitrix(int $invoiceId): void
    {
        try {
            // Получаем код поля из сделок в Битрикс24
            $bxAlreadyPaidField = Setting::getValueByCode('BITRIX_ALREADY_PAID');
            if (empty($bxAlreadyPaidField)) {
                Log::error('Настройка BITRIX_ALREADY_PAID не настроена в системе');
                return;
            }

            // Находим счет по его ID
            $invoice = Invoice::find($invoiceId);
            if (!$invoice) {
                Log::error('Счет не найден в базе данных', [
                    'invoice_id' => $invoiceId
                ]);
                return;
            }

            // Получаем пользователя и его ID в Битрикс24
            $user = User::where('contact_id', $invoice->contact_id)->first();
            if (!$user) {
                Log::error('Пользователь не найден в базе данных', [
                    'invoice_id' => $invoiceId,
                    'contact_id' => $invoice->contact_id
                ]);
                return;
            }

            $b24DealId = $user->id_b24;

            // Получаем все счета пользователя
            $invoices = $this->getUserInvoices($user);

            // Вычисляем общую сумму оплаченных счетов
            $alreadyPaid = $invoices->sum('opportunity');
            Log::info('Данные для обновления подготовлены', [
                'deal_id' => $user->id_b24,
                'bxAlreadyPaidField' => $bxAlreadyPaidField,
                'alreadyPaid' => $alreadyPaid
            ]);

            // Обновляем поле с суммой в сделке Битрикс24
            $response = $this->serviceBuilder->getCRMScope()->deal()->update(
                $b24DealId,
                [$bxAlreadyPaidField => $alreadyPaid]
            );

            if ($response->isSuccess()) {
                Log::info('Поле "Сумма оплаченных счетов в личном кабинете" в Битрикс24 успешно обновлено', [
                    'deal_id' => $user->id_b24,
                    'alreadyPaid' => $alreadyPaid
                ]);
            } else {
                Log::warning('Не удалось обновить сумму в Битрикс24 для сделки ID: ' . $b24DealId);
            }
        } catch (Exception $e) {
            Log::error('Ошибка при обновлении суммы в Битрикс24: ' . $e->getMessage());
        }
    }
}
