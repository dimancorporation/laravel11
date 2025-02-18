<?php

namespace App\Http\Controllers;

use App\Models\ThemeSetting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ThemeController extends Controller
{

    public function update(Request $request): RedirectResponse
    {
        $themeName = $request->input('theme_name');
        $currentTheme = ThemeSetting::where('theme_name', $themeName)->first();
        $currentTheme->update([
            'is_active' => true,
        ]);
        ThemeSetting::where('id', '!=', $currentTheme->id)->update(['is_active' => false]);
        return redirect()->back()->with('success', 'Тема успешно обновлена!');
    }
}
