<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PaymentController extends Controller
{

    public function index(Request $request): View
    {
        $user = $request->user();
        $invoices = Invoice::where('contact_id', $user->contact_id)->get();
        return view('payment', compact('invoices'));
    }
}
