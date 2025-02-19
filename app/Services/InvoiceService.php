<?php

namespace App\Services;

use App\Models\Invoice;
use App\Models\Setting;
use Illuminate\Support\Facades\Log;

class InvoiceService
{
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
}
