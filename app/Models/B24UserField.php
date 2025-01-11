<?php



namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Model representing b24 user fields.
 *
 * This model is used for managing the mapping between site fields and Bitrix24 fields.
 * It supports filtering based on the site field and retrieving the corresponding uf_crm_code.
 * @property string site_field
 * @property string b24_field
 * @property string uf_crm_code
 * @method static Builder|B24UserField bySiteField(string $siteField) Scope to filter by site field.
 */
class B24UserField extends Model
{
    use HasFactory;

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
        return self::bySiteField($siteField)
            ->value('uf_crm_code');
    }
}
