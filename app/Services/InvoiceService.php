<?php

namespace App\Services;

use App\Models\Invoice;

class InvoiceService
{
    public function getUserInvoices($user)
    {
        return Invoice::where('contact_id', $user->contact_id)
                      ->where('stage_id', 'like', '%:P')
                      ->get();
    }
}
