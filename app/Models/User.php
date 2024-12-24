<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
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
        'password',
        'role',
        'is_first_auth',
        'is_registered_myself',
        'b24_status',
        'documents_id',
        'contact_id',
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
}
