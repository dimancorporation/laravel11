<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use App\Services\SettingsService;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Log;

class SettingsController extends Controller
{
    protected SettingsService $settingsService;

    public function __construct()
    {
        $this->settingsService = app(SettingsService::class);
    }

    /**
     * @throws Exception
     */
    public function index(): View | RedirectResponse
    {
        try {
            $settingsData = $this->settingsService->getSettingsData();
            return view('settings', $settingsData);
        } catch (Exception $e) {
            // Обработка исключений или возврат ошибки пользователю
            return redirect()->back()->withErrors(['error' => 'Не удалось загрузить настройки.']);
        }
    }

    public function store(Request $request): RedirectResponse
    {
        Log::info('Пользователь начал сохранение настроек.', ['data' => $request->all()]);

        $data = $request->all();
        foreach ($data as $key => $value) {
            if ($key === '_token') continue;

            $field = Setting::where('code', $key)->first();
            if ($field) {
                $field->update([
                    'value' => $value
                ]);
                Log::info('Настройка обновлена.', ['code' => $key, 'value' => $value]);
            } else {
                Log::warning('Попытка обновления несуществующей настройки.', ['code' => $key]);
            }
        }

        Log::info('Настройки успешно сохранены.');
        return back()->with('success', 'Данные успешно сохранены.');
    }

    public function debtor(Request $request): RedirectResponse
    {
        Log::info('Пользователь начал сохранение настроек для должника.', ['data' => $request->all()]);

        $data = $request->all();
        foreach ($data as $key => $value) {
            if ($key === '_token') continue;

            $field = Setting::where('code', $key)->first();
            if ($field) {
                $field->update([
                    'value' => htmlspecialchars($value)
                ]);
                Log::info('Настройка для должника обновлена.', ['code' => $key, 'value' => $value]);
            } else {
                Log::warning('Попытка обновления несуществующей настройки для должника.', ['code' => $key]);
            }
        }

        Log::info('Настройки для должника успешно сохранены.');
        return back()->with('success', 'Данные успешно сохранены.');
    }
}
