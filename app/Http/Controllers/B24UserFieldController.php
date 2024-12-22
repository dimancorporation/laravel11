<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Models\B24UserField;

class B24UserFieldController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        // Получение всех полей формы
        $data = $request->all();

        foreach ($data as $key => $value) {
            // Пропускаем скрытые поля
            if ($key === '_token') continue;

            $field = B24UserField::where('site_field', $key)->first();
            if ($field) {
                $field->update([
                    'uf_crm_code' => $value
                ]);
            }
        }

        return back()->with('success', 'Данные успешно сохранены.');
    }
}
