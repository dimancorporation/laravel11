<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class B24UserField extends Model
{
    protected $table = 'b24_user_fields';

    protected $fillable = [
        'site_field',
        'b24_field',
        'uf_crm_code',
    ];

    /**
     * Scope to filter by site field.
     *
     * @param  Builder  $query
     * @param  string  $siteField
     * @return Builder
     */
    public function scopeBySiteField(Builder $query, string $siteField): Builder
    {
        return $query->where('site_field', $siteField);
    }


    /**
     * Get the uf_crm_code value for a given site field.
     *
     * @param  string  $siteField
     * @return string|null
     */
    public static function getUfCrmCode(string $siteField): ?string
    {
        return self::query()
            ->bySiteField($siteField)
            ->value('uf_crm_code');
    }
}
