<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $table = 'invoices';
    protected $fillable = [
        'b24_invoice_id',
        'b24_payment_type_id',
        'b24_payment_type_name',
        'title',
        'created_time',
        'updated_time',
        'moved_time',
        'category_id',
        'stage_id',
        'previous_stage_id',
        'begin_date',
        'closed_date',
        'contact_id',
        'opportunity',
        'is_manual_opportunity',
        'currency_id',
    ];

    /**
     * Получение значения uf_crm_code
     *
     * @return string|null
     */
    public static function getUfCrmCode($field)
    {
        return self::where('site_field', $field)->value('uf_crm_code');
    }
}
