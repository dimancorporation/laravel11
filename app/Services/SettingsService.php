<?php

namespace App\Services;

use App\Models\Setting;
use App\Models\B24Status;
use App\Models\B24UserField;
use App\Models\B24DocField;
use App\Models\ThemeSetting;
use Exception;
use Illuminate\Support\Facades\Log;

class SettingsService
{
    public function getPaymentSettings(): array
    {
        $codes = ['TERMINAL_KEY', 'EMAIL_COMPANY'];
        return Setting::whereIn('code', $codes)->pluck('value')->toArray();
    }

    public function getValueByCode(string $code): string
    {
        return Setting::where('code', $code)->first()->value;
    }

    public function getBitrixWebhookUrl()
    {
        return Setting::where('code', 'BITRIX_WEBHOOK_URL')->first()->value;
    }

    /**
     * @throws Exception
     */
    public function getSettingsData(): array
    {
        try {
            $b24UserFields = B24UserField::all()->sortBy('id');
            $b24DocFields = B24DocField::all()->sortBy('id');
            $b24Statuses = B24Status::all()->sortBy('id');
            $settingsFields = Setting::where('code', '!=', 'DEBTOR_MESSAGE')->orderBy('id')->get();
            $tinymceApiKey = $settingsFields->firstWhere('code', 'TINYMCE_API_KEY')?->value;
            $debtorMessage = Setting::where('code', 'DEBTOR_MESSAGE')->first();
            $debtorMessage = htmlspecialchars_decode($debtorMessage->value);
            $activeTheme = ThemeSetting::active();
            $themes = ThemeSetting::where('is_visible', true)->get();

            return compact('b24UserFields', 'b24DocFields', 'b24Statuses', 'settingsFields', 'debtorMessage', 'tinymceApiKey', 'activeTheme', 'themes');
        } catch (Exception $e) {
            Log::error('Ошибка при получении данных для страницы настроек: ' . $e->getMessage(), [
                'exception' => $e,
            ]);
            throw new Exception('Ошибка при получении данных для страницы настроек: ' . $e->getMessage());
        }
    }
}
