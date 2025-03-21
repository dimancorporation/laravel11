<?php

namespace App\Http\Controllers;

use App\Models\B24Documents;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class DocumentsController extends Controller
{

    public function index(Request $request): View
    {
        /*
         * получить список из таблицы b24_doc_fields
         */
        $documentFields = [
            'passport_all_pages' => 'Паспорт (все страницы)',
            'scan_inn' => 'Скан ИНН',
            'snils' => 'Скан СНИЛСа',
            'marriage_certificate' => 'Скан свид. о заключении брака (если клиент в браке).',
            'passport_spouse' => 'Паспорт супруга (если клиент в браке)',
            'snils_spouse' => 'Скан СНИЛСа в отношении супруга(и).',
            'divorce_certificate' => 'Скан. свид. о расторжении брака (если брак ранее расторгался).',
            'ndfl' => 'Скан 2-НДФЛ за последние 3 года (если клиент раб. официально).',
            'childrens_birth_certificate' => 'Скан свид. о рождении детей (если у клиента есть иждивенцы до 18 лет).',
            'extract_egrn' => 'Скан выписки из ЕГРН недвижимости за последние 3 года по всей территории РФ.',
            'pts' => 'Скан ПТС (если у клиента в собственности есть движ. имущество)',
            'sts' => 'Скан СТС (если у клиента в собственности есть движ. имущество).',
            'pts_spouse' => 'Скан ПТС (если в собственности супруга(и) есть движимое имущество).',
            'sts_spouse' => 'Скан СТС (если в собственности супруга(и) есть движимое имущество).',
            'dkp' => 'Скан ДКП (если клиент за последние 3 г. продавал движимое имущество).',
            'dkp_spouse' => 'Скан ДКП (если супруг(а) продавал(а) за последние 3 г. движимое имущество).',
            'other' => 'Другое',
        ];

        $user = $request->user();
        $documents = B24Documents::find($user->documents_id);

        if (!$documents) {
            Log::warning('Документы пользователя не найдены в таблице: ', [
                'user_id' => $user->id,
                'documents' => $documents
            ]);
            $documents = array_fill_keys(array_keys($documentFields), false);
        }

        return view('documents', compact('user', 'documents', 'documentFields'));
    }
}
