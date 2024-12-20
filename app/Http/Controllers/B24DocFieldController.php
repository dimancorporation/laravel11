<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Models\B24DocField;

// Предположим, что у вас уже создана модель для таблицы b24_doc_fields

class B24DocFieldController extends Controller
{
    // 1,doc_passport_all_pages,ПАСПОРТ (ВСЕ СТРАНИЦЫ),UF_CRM_1708509490009,,
    public function store(Request $request): RedirectResponse
    {
        // Получение всех полей формы
        $data = $request->all();

        foreach ($data as $key => $value) {
            // Пропускаем скрытые поля
            if ($key === '_token') continue;

            // Находим запись в таблице по полю site_field
            $field = B24DocField::where('site_field', $key)->first();

            // Если запись найдена, обновляем значение uf_crm_code
            if ($field) {
                $field->update([
                    'uf_crm_code' => $value
                ]);
            }
        }

        // Возвращаем сообщение об успехе
        return back()->with('success', 'Документы успешно сохранены.');
    }
}
