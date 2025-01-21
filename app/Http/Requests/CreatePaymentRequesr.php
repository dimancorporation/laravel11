<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreatePaymentRequesr extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        // todo Уточнить про валидацию
        return [
            'b24_deal_id' => ['required', 'string'],
            'b24_contact_id' => ['required', 'string'],
            'b24_invoice_id' => ['nullable', 'string'],
            'order_id' => ['required', 'string'],
            'success' => ['required', 'boolean'],
            'status' => ['required', 'string'],
            'payment_id' => ['required', 'string'],
            'amount' => ['required', 'numeric', 'min:0'],
            'card_id' => ['nullable', 'string'],
            'email' => ['required', 'email'],
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'regex:/^\+7[0-9]{10}$/'],
            'source' => ['nullable', 'string'],
            'user_agent' => ['nullable', 'string'],
        ];
    }
}
