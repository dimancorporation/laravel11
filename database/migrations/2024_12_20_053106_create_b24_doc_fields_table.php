<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('b24_doc_fields', function (Blueprint $table) {
            $table->id();
            $table->string('site_field')->unique();
            $table->string('b24_field')->unique();
            $table->string('uf_crm_code')->unique();
            $table->timestamps();
        });

        DB::table('b24_doc_fields')->insert([
            ['site_field' => 'passport_all_pages',          'b24_field' => 'ПАСПОРТ (ВСЕ СТРАНИЦЫ)',            'uf_crm_code' => 'UF_CRM_1708509490009'],
            ['site_field' => 'scan_inn',                    'b24_field' => 'СКАН ИНН',                          'uf_crm_code' => 'UF_CRM_1708509740365'],
            ['site_field' => 'snils',                       'b24_field' => 'СНИЛС',                             'uf_crm_code' => 'UF_CRM_1708510606993'],
            ['site_field' => 'marriage_certificate',        'b24_field' => 'СВИДЕТЕЛЬСТВО О ЗАКЛЮЧЕНИИ БРАКА',  'uf_crm_code' => 'UF_CRM_1708510636060'],
            ['site_field' => 'passport_spouse',             'b24_field' => 'ПАСПОРТ СУПРУГА',                   'uf_crm_code' => 'UF_CRM_1708510675413'],
            ['site_field' => 'snils_spouse',                'b24_field' => 'СНИЛС СУПРУГА',                     'uf_crm_code' => 'UF_CRM_1708510724402'],
            ['site_field' => 'divorce_certificate',         'b24_field' => 'СВИДЕТЕЛЬСТВО О РАСТОРЖЕНИИ БРАКА', 'uf_crm_code' => 'UF_CRM_1708510771069'],
            ['site_field' => 'ndfl',                        'b24_field' => '2 НДФЛ ЗА ПОСЛЕДНИЕ 3 ГОДА',        'uf_crm_code' => 'UF_CRM_1708510936813'],
            ['site_field' => 'childrens_birth_certificate', 'b24_field' => 'СВИДЕТЕЛЬСТВО О РОЖДЕНИИ ДЕТЕЙ',    'uf_crm_code' => 'UF_CRM_1708510989101'],
            ['site_field' => 'extract_egrn',                'b24_field' => 'ВЫПИСКА ИЗ ЕГРН НЕДВИЖИМОСТИ',      'uf_crm_code' => 'UF_CRM_1708511092399'],
            ['site_field' => 'scan_pts',                    'b24_field' => 'ПТС',                               'uf_crm_code' => 'UF_CRM_1708511164599'],
            ['site_field' => 'sts',                         'b24_field' => 'СТС',                               'uf_crm_code' => 'UF_CRM_1708511175692'],
            ['site_field' => 'pts_spouse',                  'b24_field' => 'ПТС СУПРУГА',                       'uf_crm_code' => 'UF_CRM_1708511204032'],
            ['site_field' => 'sts_spouse',                  'b24_field' => 'СТС СУПРУГА',                       'uf_crm_code' => 'UF_CRM_1708511215650'],
            ['site_field' => 'dkp',                         'b24_field' => 'ДКП',                               'uf_crm_code' => 'UF_CRM_1708511237220'],
            ['site_field' => 'dkp_spouse',                  'b24_field' => 'ДКП СУПРУГ',                        'uf_crm_code' => 'UF_CRM_1708511248493'],
            ['site_field' => 'other',                       'b24_field' => 'ДРУГОЕ',                            'uf_crm_code' => 'UF_CRM_1708511269272'],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('b24_doc_fields');
    }
};
