<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * User model for the Laravel application.
 *
 * Represents a user in the system and provides various functionalities,
 * such as role management, B24 status associations, and custom attribute accessors.
 *
 * @property-read int id
 * @property-read string role
 * @property-read string id_b24
 * @property-read mixed $b24Status
 * @property-read mixed $contact_id
 * @mixin Builder
 * @method static Builder byEmailAndPhone(string $string, mixed $email)
 * @method User firstOrFail($columns = ['*'])
 */
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'id',
        'id_b24',
        'name',
        'email',
        'phone',
        'password',
        'role',
        'is_first_auth',
        'is_registered_myself',
        'b24_status',
        'documents_id',
        'contact_id',
        'link_to_court',
        'sum_contract',
        'message_from_b24',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function b24Documents(): BelongsTo
    {
        return $this->belongsTo(B24Status::class, 'b24_documents', 'id');
    }

    public function b24Status(): BelongsTo
    {
        return $this->belongsTo(B24Status::class, 'b24_status', 'id');
    }

    /**
     * Defines a one-to-many relationship with the Payment model.
     *
     * This method retrieves all payments associated with the current model.
     *
     * @return HasMany
     */
    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }

    public function isDebtor(): bool
    {
        $b24Status = $this->b24Status;
        return $b24Status && $b24Status->name === 'Должник';
    }

    public function getRoleAttribute($value): string
    {
        return ucfirst($value);
    }

    public function isAdmin(): bool
    {
        return $this->role === 'Admin';
    }

    public function isUser(): bool
    {
        return $this->role === 'User';
    }

    public function isBlocked(): bool
    {
        return $this->role === 'Blocked';
    }
    public function getIdB24(): bool
    {
        return $this->id_b24;
    }

    /**
     * Scope a query to filter by email and phone.
     *
     * @param Builder $query
     * @param string $email
     * @param string $phone
     * @return Builder
     */
    public function scopeByEmailAndPhone(Builder $query, string $email, string $phone): Builder
    {
        return $query->where('email', $email)
            ->where('phone', '+7' . $phone);
    }
}
