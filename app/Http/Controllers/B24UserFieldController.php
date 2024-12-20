<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Models\B24UserField;

// Предположим, что у вас уже создана модель для таблицы b24_user_fields

class B24UserFieldController extends Controller
{
    // 1,USER_CREATE_ACCOUNT,Создать лк клиенту,UF_CRM_1708511654449,,
    public function store(Request $request): RedirectResponse
    {
        // Получение всех полей формы
        $data = $request->all();

        foreach ($data as $key => $value) {
            // Пропускаем скрытые поля
            if ($key === '_token') continue;

            // Находим запись в таблице по полю site_field
            $field = B24UserField::where('site_field', $key)->first();
//            dump($field);
            // Если запись найдена, обновляем значение uf_crm_code
            if ($field) {
                $field->update([
                    'uf_crm_code' => $value
                ]);
            }
        }

        // Возвращаем сообщение об успехе
        return back()->with('success', 'Данные успешно сохранены.');
    }
}
