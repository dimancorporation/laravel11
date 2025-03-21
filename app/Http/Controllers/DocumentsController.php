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
            'passport_all_pages' => 'ПАСПОРТ (ВСЕ СТРАНИЦЫ)',
            'scan_inn' => 'СКАН ИНН',
            'snils' => 'СНИЛС',
            'marriage_certificate' => 'СВИДЕТЕЛЬСТВО О ЗАКЛЮЧЕНИИ БРАКА',
            'passport_spouse' => 'ПАСПОРТ СУПРУГА',
            'snils_spouse' => 'СНИЛС СУПРУГА',
            'divorce_certificate' => 'СВИДЕТЕЛЬСТВО О РАСТОРЖЕНИИ БРАКА',
            'ndfl' => '2 НДФЛ ЗА ПОСЛЕДНИЕ 3 ГОДА',
            'childrens_birth_certificate' => 'СВИДЕТЕЛЬСТВО О РОЖДЕНИИ ДЕТЕЙ',
            'extract_egrn' => 'ВЫПИСКА ИЗ ЕГРН НЕДВИЖИМОСТИ',
            'pts' => 'ПТС',
            'sts' => 'СТС',
            'pts_spouse' => 'ПТС СУПРУГА',
            'sts_spouse' => 'СТС СУПРУГА',
            'dkp' => 'ДКП',
            'dkp_spouse' => 'ДКП СУПРУГ',
            'other' => 'ДРУГОЕ',
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
