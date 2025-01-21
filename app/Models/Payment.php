<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * User model for the Laravel application.
 *
 * Represents a user in the system and provides various functionalities,
 * such as role management, B24 status associations, and custom attribute accessors.
 *
 * @property mixed $id
 * @property mixed $payment_id
 * @property mixed $order_id
 * @mixin Builder
 * @method static Builder findByOrderAndPayment(string $orderId, string $paymentId)
 */
class Payment extends Model
{
    use HasFactory;
    const CONFIRMED_STATUS = 'CONFIRMED';

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

    /**
     * Scope a query to find a record by order ID and payment ID.
     *
     * @param Builder $query The query builder instance.
     * @param mixed $orderId The ID of the order to filter by.
     * @param mixed $paymentId The ID of the payment to filter by.
     * @return Builder The updated query builder instance.
     */
    public function scopeFindByOrderAndPayment(Builder $query, string $orderId, string $paymentId): Builder
    {
        return $query->where('order_id', $orderId)
            ->where('payment_id', $paymentId);
    }

    public function setPhoneAttribute($value): void
    {
        $this->attributes['phone'] = '+7' . ltrim($value, ' +7');
    }

    /**
     * Define an inverse one-to-many relationship with the User model.
     *
     * @return BelongsTo The relationship instance.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Set the amount attribute by dividing the provided value by 100.
     *
     * @param int $value
     * @return void
     */
    public function setAmountAttribute(int $value): void
    {
        $this->attributes['amount'] = ceil($value / 100);
    }
}
