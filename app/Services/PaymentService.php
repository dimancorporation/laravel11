<?php

namespace App\Services;

use App\Models\Payment;
use App\Models\User;

class PaymentService
{
    public function findUser(array $data): ?User
    {
        return User::where('email', $data['Data']['Email'])
                   ->where('phone', '+7' . $data['Data']['Phone'])
                   ->first();
    }

    public function findPayment(array $data): ?Payment
    {
        return Payment::where('order_id', $data['OrderId'])
                      ->where('payment_id', $data['PaymentId'])
                      ->first();
    }

    public function createPayment(User $user, array $data): void
    {
        Payment::create([
            'b24_deal_id' => $user->id_b24,
            'b24_contact_id' => $user->contact_id,
            'b24_invoice_id' => null,
            'order_id' => $data['OrderId'],
            'success' => $data['Success'],
            'status' => $data['Status'],
            'payment_id' => $data['PaymentId'],
            'amount' => $data['Amount'] / 100,
            'card_id' => $data['CardId'],
            'email' => $data['Data']['Email'],
            'name' => $data['Data']['Name'],
            'phone' => '+7' . $data['Data']['Phone'],
            'source' => $data['Data']['Source'],
            'user_agent' => $data['Data']['user_agent'],
        ]);
    }

    public function updateExistingPayment(Payment $payment, array $data): void
    {
        $payment->update(['status' => $data['Status']]);
    }

    public function generateAdditionalInfo(Payment $payment): array
    {
        return [
            'payment_id' => $payment->id,
            'PaymentId' => $payment->payment_id,
            'OrderId' => $payment->order_id
        ];
    }
}
