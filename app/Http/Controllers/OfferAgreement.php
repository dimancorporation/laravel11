<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class OfferAgreement extends Controller
{

    public function store(Request $request): RedirectResponse
    {
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            Storage::disk('public')->putFileAs(
                'docs', $file, 'offer_agreement.pdf'
            );

            return back()->with('success', 'Данные успешно сохранены.');
        }
        return back()->with('error', 'Не удалось загрузить файл.');
    }
}
