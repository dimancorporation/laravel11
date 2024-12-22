<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class B24Status extends Model
{
    protected $table = 'b24_statuses';

    protected $fillable = ['id', 'name', 'b24_status_id'];

    public function user(): HasMany
    {
        return $this->hasMany(User::class);
    }
}
