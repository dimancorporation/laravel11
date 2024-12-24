<?php

namespace Database\Seeders;

use App\Models\B24UserField;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class B24UserFields extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'site_field'  => 'user_create_account',
                'b24_field'   => 'СОЗДАТЬ ЛК КЛИЕНТУ',
                'uf_crm_code' => 'UF_CRM_1708511654449',
                'created_at'  => Carbon::now(),
            ],
            [
                'site_field'  => 'user_login',
                'b24_field'   => 'ЛОГИН ЛК КЛИЕНТА',
                'uf_crm_code' => 'UF_CRM_1708511589360',
                'created_at'  => Carbon::now(),
            ],
            [
                'site_field'  => 'user_password',
                'b24_field'   => 'ПАРОЛЬ ЛК КЛИЕНТА',
                'uf_crm_code' => 'UF_CRM_1708511607581',
                'created_at'  => Carbon::now(),
            ],
            [
                'site_field'  => 'user_status',
                'b24_field'   => 'СТАТУС ДЛЯ ЛК КЛИЕНТА',
                'uf_crm_code' => 'UF_CRM_1709533755311',
                'created_at'  => Carbon::now(),
            ],
            [
                'site_field'  => 'user_contract_amount',
                'b24_field'   => 'СУММА ДОГОВОРА',
                'uf_crm_code' => 'UF_CRM_1725026451112',
                'created_at'  => Carbon::now(),
            ],
            [
                'site_field'  => 'user_message_from_b24',
                'b24_field'   => 'СООБЩЕНИЕ КЛИЕНТУ ОТ КОМПАНИИ',
                'uf_crm_code' => 'UF_CRM_1708511318200',
                'created_at'  => Carbon::now(),
            ],
            [
                'site_field'  => 'user_link_to_court',
                'b24_field'   => 'ССЫЛКА НА ДЕЛО В КАДР. АРБИТР',
                'uf_crm_code' => 'UF_CRM_1708511472339',
                'created_at'  => Carbon::now(),
            ],
            [
                'site_field'  => 'user_last_auth_date',
                'b24_field'   => 'ДАТА ПОСЛЕДНЕЙ АВТОРИЗАЦИИ (МСК)',
                'uf_crm_code' => 'UF_CRM_1715524078722',
                'created_at'  => Carbon::now(),
            ],
            [
                'site_field'  => 'doc_passport_all_pages',
                'b24_field'   => 'ПАСПОРТ (ВСЕ СТРАНИЦЫ)',
                'uf_crm_code' => 'UF_CRM_1708509490009',
                'created_at'  => Carbon::now()
            ],
            [
                'site_field'  => 'doc_scan_inn',
                'b24_field'   => 'СКАН ИНН',
                'uf_crm_code' => 'UF_CRM_1708509740365',
                'created_at'  => Carbon::now()
            ],
            [
                'site_field'  => 'doc_snils',
                'b24_field'   => 'СНИЛС',
                'uf_crm_code' => 'UF_CRM_1708510606993',
                'created_at'  => Carbon::now()
            ],
            [
                'site_field'  => 'doc_marriage_certificate',
                'b24_field'   => 'СВИДЕТЕЛЬСТВО О ЗАКЛЮЧЕНИИ БРАКА',
                'uf_crm_code' => 'UF_CRM_1708510636060',
                'created_at'  => Carbon::now()
            ],
            [
                'site_field'  => 'doc_passport_spouse',
                'b24_field'   => 'ПАСПОРТ СУПРУГА',
                'uf_crm_code' => 'UF_CRM_1708510675413',
                'created_at'  => Carbon::now()
            ],
            [
                'site_field'  => 'doc_snils_spouse',
                'b24_field'   => 'СНИЛС СУПРУГА',
                'uf_crm_code' => 'UF_CRM_1708510724402',
                'created_at'  => Carbon::now()
            ],
            [
                'site_field'  => 'doc_divorce_certificate',
                'b24_field'   => 'СВИДЕТЕЛЬСТВО О РАСТОРЖЕНИИ БРАКА',
                'uf_crm_code' => 'UF_CRM_1708510771069',
                'created_at'  => Carbon::now()
            ],
            [
                'site_field'  => 'doc_ndfl',
                'b24_field'   => '2 НДФЛ ЗА ПОСЛЕДНИЕ 3 ГОДА',
                'uf_crm_code' => 'UF_CRM_1708510936813',
                'created_at'  => Carbon::now()
            ],
            [
                'site_field'  => 'doc_childrens_birth_certificate',
                'b24_field'   => 'СВИДЕТЕЛЬСТВО О РОЖДЕНИИ ДЕТЕЙ',
                'uf_crm_code' => 'UF_CRM_1708510989101',
                'created_at'  => Carbon::now()
            ],
            [
                'site_field'  => 'doc_extract_egrn',
                'b24_field'   => 'ВЫПИСКА ИЗ ЕГРН НЕДВИЖИМОСТИ',
                'uf_crm_code' => 'UF_CRM_1708511092399',
                'created_at'  => Carbon::now()
            ],
            [
                'site_field'  => 'doc_scan_pts',
                'b24_field'   => 'ПТС',
                'uf_crm_code' => 'UF_CRM_1708511164599',
                'created_at'  => Carbon::now()
            ],
            [
                'site_field'  => 'doc_sts',
                'b24_field'   => 'СТС',
                'uf_crm_code' => 'UF_CRM_1708511175692',
                'created_at'  => Carbon::now()
            ],
            [
                'site_field'  => 'doc_pts_spouse',
                'b24_field'   => 'ПТС СУПРУГА',
                'uf_crm_code' => 'UF_CRM_1708511204032',
                'created_at'  => Carbon::now()
            ],
            [
                'site_field'  => 'doc_sts_spouse',
                'b24_field'   => 'СТС СУПРУГА',
                'uf_crm_code' => 'UF_CRM_1708511215650',
                'created_at'  => Carbon::now()
            ],
            [
                'site_field'  => 'doc_dkp',
                'b24_field'   => 'ДКП',
                'uf_crm_code' => 'UF_CRM_1708511237220',
                'created_at'  => Carbon::now()
            ],
            [
                'site_field'  => 'doc_dkp_spouse',
                'b24_field'   => 'ДКП СУПРУГ',
                'uf_crm_code' => 'UF_CRM_1708511248493',
                'created_at'  => Carbon::now()
            ],
            [
                'site_field'  => 'doc_other',
                'b24_field'   => 'ДРУГОЕ',
                'uf_crm_code' => 'UF_CRM_1708511269272',
                'created_at'  => Carbon::now()
            ],
        ];

        B24UserField::query()->insert($data);
    }
}
