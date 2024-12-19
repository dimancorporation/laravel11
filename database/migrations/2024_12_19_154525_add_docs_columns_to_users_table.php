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
            $table->boolean('passport_all_pages')->default(false)->after('already_paid'); // Паспорт (все страницы)
            $table->boolean('pts')->default(false)->after('passport_all_pages'); // ПТС
            $table->boolean('scan_inn')->default(false)->after('pts'); // Скан ИНН
            $table->boolean('snils')->default(false)->after('scan_inn'); // Скан СНИЛСа
            $table->boolean('marriage_certificate')->default(false)->after('snils'); // Скан свид. о заключении брака (если клиент в браке).
            $table->boolean('snils_spouse')->default(false)->after('marriage_certificate'); // Скан СНИЛСа в отношении супруга(и).
            $table->boolean('divorce_certificate')->default(false)->after('snils_spouse'); // Скан. свид. о расторжении брака (если брак ранее расторгался)
            $table->boolean('ndfl')->default(false)->after('divorce_certificate'); // Скан 2-НДФЛ за последние 3 года (если клиент раб. официально)
            $table->boolean('childrens_birth_certificate')->default(false)->after('ndfl'); // Скан свид. о рождении детей (если у клиента есть иждивенцы до 18 лет)
            $table->boolean('extract_egrn')->default(false)->after('childrens_birth_certificate'); // Скан выписки из ЕГРН недвижимости за последние 3 года по всей территории РФ
            $table->boolean('scan_pts')->default(false)->after('extract_egrn'); // Скан ПТС (если у клиента в собственности есть движ. имущество)
            $table->boolean('sts')->default(false)->after('scan_pts'); // Скан СТС (если у клиента в собственности есть движ. имущество)
            $table->boolean('pts_spouse')->default(false)->after('sts'); // Скан ПТС (если в собственности супруга(и) есть движимое имущество)
            $table->boolean('sts_spouse')->default(false)->after('pts_spouse'); // Скан СТС (если в собственности супруга(и) есть движимое имущество)
            $table->boolean('dkp')->default(false)->after('sts_spouse'); // Скан ДКП (если клиент за последние 3 г. продавал движимое имущество)
            $table->boolean('dkp_spouse')->default(false)->after('dkp'); // Скан ДКП (если супруг(а) продавал(а) за последние 3 г. движимое имущество)
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
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
};
