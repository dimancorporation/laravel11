<?php

namespace App\Services;

use App\Models\Invoice;

class InvoiceService
{
    public function getUserInvoices($user)
    {
        /* статус в б24 оплаченного счета 'DT31_2:P', но может и меняться, например: 'DT31_3:P' */
        return Invoice::where('contact_id', $user->contact_id)
                      ->where('stage_id', 'like', '%:P')
                      ->get();
    }
}
