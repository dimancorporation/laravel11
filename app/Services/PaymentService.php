<?php

namespace App\Services;

use App\Exceptions\ValidationException;
use App\Models\Payment;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class PaymentService
{
    public function findUser(Request $request): User
    {
        return User::byEmailAndPhone(
            $request->input('Data.Email'),
            $request->input('Data.Phone')
        )
            ->first();
    }

    public function findPayment(Request $request): ?Payment
    {
        return Payment::findByOrderAndPayment(
            $request->input('OrderId'),
            $request->input('PaymentId')
        )
            ->first();
    }

    public function createPayment(Request $request): void
    {
        try {
            $user = $this->findUser($request);

            // todo выглядит слишком громоздко, можно убрать в валидацию
            $user->payments()->create([
                'b24_deal_id' => $user->id_b24,
                'b24_contact_id' => $user->contact_id,
                'b24_invoice_id' => null,
                'order_id' => $request->input('OrderId'),
                'success' => $request->input('Success'),
                'status' => $request->input('Status'),
                'payment_id' => $request->input('PaymentId'),
                'amount' => $request->input('Amount'),
                'card_id' => $request->input('CardId'),
                'email' => $request->input('Data.Email'),
                'name' => $request->input('Data.Name'),
                'phone' => '+7' . $request->input('Data.Phone'),
                'source' => $request->input('Data.Source'),
                'user_agent' => $request->input('Data.user_agent'),
            ]);
        } catch (ModelNotFoundException $e) {
            dump($e->getMessage());
        }

        // can use $this->findUser($request) or use relations
        // need replace for $request->validated()
//        Payment::create([
//            'b24_deal_id' => $user->id_b24,
//            'b24_contact_id' => $user->contact_id,
//            'b24_invoice_id' => null,
//            'order_id' => $data['OrderId'],
//            'success' => $data['Success'],
//            'status' => $data['Status'],
//            'payment_id' => $data['PaymentId'],
//            'amount' => $data['Amount'] / 100,
//            'card_id' => $data['CardId'],
//            'email' => $data['Data']['Email'],
//            'name' => $data['Data']['Name'],
//            'phone' => '+7' . $data['Data']['Phone'],
//            'source' => $data['Data']['Source'],
//            'user_agent' => $data['Data']['user_agent'],
//        ]);
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
