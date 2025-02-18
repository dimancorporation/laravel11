<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ThemeSetting extends Model
{
    protected $table = 'theme_settings';
    protected $fillable = [
        'theme_name',
        'is_active',
        'is_visible',
        'description',
    ];

    public static function active()
    {
        return self::where('is_active', true)->first();
    }
}
