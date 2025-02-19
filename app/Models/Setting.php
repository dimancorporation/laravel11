<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $table = 'settings';
    protected $fillable = [
        'code',
        'name',
        'value',
    ];

    public static function getValueByCode(string $code)
    {
        $setting = self::where('code', $code)->first();
        return $setting ? $setting->value : null;
    }
}
