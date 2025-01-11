<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use App\Models\Payment;
use App\Models\User;

class PaymentService
{
    private array $data;
    private string $path;

    public function __construct(array $data)
    {
        $this->data = $data;
        $this->path = 'logs/log.txt';
    }

    public function logRequest(): void
    {
        Log::info('Онлайн касса прислала данные о платеже:', $this->data);
        Storage::put($this->path, json_encode($this->data, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
    }

    public function findUser(): ?User
    {
        return User::where('email', $this->data['Data']['Email'])
                   ->where('phone', '+7' . $this->data['Data']['Phone'])
                   ->first();
    }

    public function findPayment(): ?Payment
    {
        return Payment::where('order_id', $this->data['OrderId'])
                      ->where('payment_id', $this->data['PaymentId'])
                      ->first();
    }

    public function createPayment(User $user): void
    {
        Payment::create([
            'b24_deal_id' => $user->id_b24,
            'b24_contact_id' => $user->contact_id,
            'b24_invoice_id' => null,
            'order_id' => $this->data['OrderId'],
            'success' => $this->data['Success'],
            'status' => $this->data['Status'],
            'payment_id' => $this->data['PaymentId'],
            'amount' => $this->data['Amount'] / 100,
            'card_id' => $this->data['CardId'],
            'email' => $this->data['Data']['Email'],
            'name' => $this->data['Data']['Name'],
            'phone' => '+7' . $this->data['Data']['Phone'],
            'source' => $this->data['Data']['Source'],
            'user_agent' => $this->data['Data']['user_agent'],
        ]);
    }

    public function updateExistingPayment(Payment $payment): void
    {
        $payment->update(['status' => $this->data['Status']]);
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
