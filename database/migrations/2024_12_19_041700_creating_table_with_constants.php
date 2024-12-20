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
        Schema::create('constants', function (Blueprint $table) {
            $table->id();
            $table->string('site_field')->unique();
            $table->string('b24_field')->unique();
            $table->string('uf_crm_code')->unique();
            $table->timestamps();
        });

        DB::table('constants')->insert([
            [
                'site_field' => 'user_create_account',
                'b24_field' => 'СОЗДАТЬ ЛК КЛИЕНТУ',
                'uf_crm_code' => 'UF_CRM_1708511654449',
            ],
            [
                'site_field' => 'user_login',
                'b24_field' => 'ЛОГИН ЛК КЛИЕНТА',
                'uf_crm_code' => 'UF_CRM_1708511589360',
            ],
            [
                'site_field' => 'user_password',
                'b24_field' => 'ПАРОЛЬ ЛК КЛИЕНТА',
                'uf_crm_code' => 'UF_CRM_1708511607581',
            ],
            [
                'site_field' => 'user_status',
                'b24_field' => 'СТАТУС ДЛЯ ЛК КЛИЕНТА',
                'uf_crm_code' => 'UF_CRM_1709533755311',
            ],
            [
                'site_field' => 'user_contract_amount',
                'b24_field' => 'СУММА ДОГОВОРА',
                'uf_crm_code' => 'UF_CRM_1725026451112',
            ],
            [
                'site_field' => 'user_message_from_b24',
                'b24_field' => 'СООБЩЕНИЕ КЛИЕНТУ ОТ КОМПАНИИ',
                'uf_crm_code' => 'UF_CRM_1708511318200',
            ],
            [
                'site_field' => 'user_link_to_court',
                'b24_field' => 'ССЫЛКА НА ДЕЛО В КАДР. АРБИТР',
                'uf_crm_code' => 'UF_CRM_1708511472339',
            ],
            [
                'site_field' => 'user_last_auth_date',
                'b24_field' => 'ДАТА ПОСЛЕДНЕЙ АВТОРИЗАЦИИ (МСК)',
                'uf_crm_code' => 'UF_CRM_1715524078722',
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('constants');
    }
};
