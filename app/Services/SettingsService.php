<?php

namespace App\Services;

use App\Models\Setting;

class SettingsService
{
    public function getPaymentSettings(): array
    {
        $codes = ['TERMINAL_KEY', 'EMAIL_COMPANY'];
        return Setting::whereIn('code', $codes)->pluck('value')->toArray();
        //return Setting::whereIn('code', $codes)->get()->toArray();
    }

    public function getValueByCode(string $code): string
    {
        return Setting::where('code', $code)->first()->value;
    }

    public function getBitrixWebhookUrl()
    {
        return Setting::where('code', 'BITRIX_WEBHOOK_URL')->first()->value;
    }
}
