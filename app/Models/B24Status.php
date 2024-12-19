<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class B24Status extends Model
{
    protected $table = 'b24_statuses';

    protected $fillable = ['name'];

    public function user(): HasMany
    {
        return $this->hasMany(User::class);
    }
}
