<?php

namespace App\Http\Controllers;

use App\Models\B24UserField;
use App\Models\B24DocField;
use Illuminate\View\View;

class SettingsController extends Controller
{
    public function index(): View
    {
        $b24UserFields = B24UserField::all()->sortBy('id');
        $b24DocFields = B24DocField::all()->sortBy('id');

        return view('settings', compact('b24UserFields', 'b24DocFields'));
    }
}
