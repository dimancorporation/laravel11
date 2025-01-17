<?php

namespace App\Http\Controllers;

use App\Models\B24UserField;
use App\Models\B24DocField;
use App\Models\Setting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class SettingsController extends Controller
{
    public function index(): View
    {
        $b24UserFields = B24UserField::all()->sortBy('id');
        $b24DocFields = B24DocField::all()->sortBy('id');
        $settingsFields = Setting::all()->sortBy('id');

        return view('settings', compact('b24UserFields', 'b24DocFields', 'settingsFields'));
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
}
