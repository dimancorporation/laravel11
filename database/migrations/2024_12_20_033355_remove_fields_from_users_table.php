<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
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
            ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
};
