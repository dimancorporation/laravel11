<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $table = 'payments';
    protected $fillable = [
        'b24_deal_id',
        'b24_contact_id',
        'order_id',
        'success',
        'status',
        'payment_id',
        'amount',
        'card_id',
        'email',
        'name',
        'phone',
        'source',
        'user_agent',
    ];
}
