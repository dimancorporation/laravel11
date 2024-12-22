<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Models\B24DocField;

class B24DocFieldController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        $data = $request->all();

        foreach ($data as $key => $value) {
            if ($key === '_token') continue;

            $field = B24DocField::where('site_field', $key)->first();
            if ($field) {
                $field->update([
                    'uf_crm_code' => $value
                ]);
            }
        }

        return back()->with('success', 'Документы успешно сохранены.');
    }
}
