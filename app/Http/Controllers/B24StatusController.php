<?php

namespace App\Http\Controllers;

use App\Models\B24Status;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class B24StatusController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        // Получение всех полей формы
        $data = $request->all();

        foreach ($data as $key => $value) {
            // Пропускаем скрытые поля
            if ($key === '_token') continue;

            $field = B24Status::where('id', $key)->first();
            if ($field) {
                $field->update([
                    'b24_status_id' => $value
                ]);
            }
        }

        return back()->with('success', 'Данные успешно сохранены.');
    }
}
