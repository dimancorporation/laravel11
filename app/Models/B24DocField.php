<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class B24DocField extends Model
{
    protected $table = 'b24_doc_fields';
    protected $fillable = [
        'site_field',
        'b24_field',
        'uf_crm_code',
    ];
}
