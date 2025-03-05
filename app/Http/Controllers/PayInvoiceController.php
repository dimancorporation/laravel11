<?php

namespace App\Http\Controllers;

use App\Services\InvoiceService;
use App\Services\PaymentService;
use App\Services\SettingsService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PayInvoiceController extends Controller
{
    protected InvoiceService $invoiceService;
    protected PaymentService $paymentService;
    protected SettingsService $settingsService;

    public function __construct(InvoiceService $invoiceService, PaymentService $paymentService, SettingsService $settingsService)
    {
        $this->invoiceService = $invoiceService;
        $this->paymentService = $paymentService;
        $this->settingsService = $settingsService;
    }
    public function index(Request $request): View
    {
        $user = $request->user();
        $paymentSettings = $this->settingsService->getPaymentSettings();
        $invoices = $this->invoiceService->getUserInvoices($user);
        return view('pay-invoice', compact('invoices', 'user', 'paymentSettings'));
    }

    public function store(Request $request)
    {
        return response()->json(['message' => 'Данные успешно сохранены!'], 200);
    }
}
