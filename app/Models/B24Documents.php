<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class B24Documents extends Model
{

    protected $table = 'b24_documents';

    protected $fillable = [
        'passport_all_pages',
        'pts',
        'scan_inn',
        'snils',
        'marriage_certificate',
        'snils_spouse',
        'divorce_certificate',
        'ndfl',
        'childrens_birth_certificate',
        'extract_egrn',
        'scan_pts',
        'sts',
        'pts_spouse',
        'sts_spouse',
        'dkp',
        'dkp_spouse'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
