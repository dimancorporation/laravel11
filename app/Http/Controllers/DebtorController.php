<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\View\View;

class DebtorController extends Controller
{

    public function store(): View
    {
        $debtorMessage = Setting::where('code', 'DEBTOR_MESSAGE')->value('value');
        return view('debtor', compact('debtorMessage'));
    }
}
