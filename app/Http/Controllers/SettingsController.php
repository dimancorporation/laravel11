<?php

namespace App\Http\Controllers;

use App\Models\B24Status;
use App\Models\B24UserField;
use App\Models\B24DocField;
use App\Models\Setting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class SettingsController extends Controller
{
    public function index(): View
    {
        $b24UserFields = B24UserField::all()->sortBy('id');
        $b24DocFields = B24DocField::all()->sortBy('id');
        $b24Statuses = B24Status::all()->sortBy('id');
        $settingsFields = Setting::where('code', '!=', 'DEBTOR_MESSAGE')->orderBy('id')->get();
        $tinymceApiKey = $settingsFields->firstWhere('code', 'TINYMCE_API_KEY')?->value;
        $debtorMessage = Setting::where('code', 'DEBTOR_MESSAGE')->first();
        $debtorMessage = htmlspecialchars_decode($debtorMessage->value);

        return view('settings', compact('b24UserFields', 'b24DocFields', 'b24Statuses', 'settingsFields', 'debtorMessage', 'tinymceApiKey'));
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->all();
        foreach ($data as $key => $value) {
            if ($key === '_token') continue;

            $field = Setting::where('code', $key)->first();
            if ($field) {
                $field->update([
                    'value' => $value
                ]);
            }
        }

        return back()->with('success', 'Данные успешно сохранены.');
    }

    public function debtor(Request $request): RedirectResponse
    {
        $data = $request->all();
        Log::info('WYSIWIG:', $data);

        foreach ($data as $key => $value) {
            if ($key === '_token') continue;

            $field = Setting::where('code', $key)->first();
            if ($field) {
                $field->update([
                    'value' => htmlspecialchars($value)
                ]);
            }
        }

        return back()->with('success', 'Данные успешно сохранены.');
    }
}
