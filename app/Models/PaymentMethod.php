<?php

namespace App\Models;

use Exception;
use Illuminate\Database\Eloquent\Model;

class PaymentMethod extends Model
{
    protected $table = 'payment_methods';
    protected $fillable = [
        'b24_payment_type_id',
        'b24_payment_type_name',
    ];

    /**
     * @throws Exception
     */
    public function getPaymentName(int $paymentId): string
    {
        $paymentType = PaymentMethod::where('b24_payment_type_id', $paymentId)->first();
        if ($paymentType) {
            return $paymentType->b24_payment_type_name;
        }

        throw new Exception("Payment type with code {$paymentId} not found.");
    }
}
