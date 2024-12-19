<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(Request $request): View
    {
        $user = $request->user();
        $b24Status = $user->b24Status;
        return view('dashboard', compact('user', 'b24Status'));
    }
}
