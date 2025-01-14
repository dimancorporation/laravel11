<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->string('name');
            $table->text('value');
            $table->timestamps();
        });

        DB::table('settings')->insert([
            [
                'code' => 'BITRIX_WEBHOOK_URL',
                'name' => 'Адрес входящего вебхука Битрикс24',
                'value' => 'https://b24-e8yd3f.bitrix24.ru/rest/8/e5wovlyxp3s5ir06/'
            ],
            [
                'code' => 'BITRIX_WEBHOOK_DOMAIN',
                'name' => 'Домен Битрикс24',
                'value' => 'b24-e8yd3f.bitrix24.ru'
            ],
            [
                'code' => 'BITRIX_WEBHOOK_DEAL_TOKEN',
                'name' => 'Токен Битрикс24 для сделок',
                'value' => 'qhfxo0td2ksmbbwkj13tyniwiqz5o9nh'
            ],
            [
                'code' => 'BITRIX_WEBHOOK_INVOICE_TOKEN',
                'name' => 'Токен Битрикс24 для счетов',
                'value' => 'ek0ql16yrhe68hfyb9cbr91h8x3s3eax'
            ],
            [
                'code' => 'BITRIX_INVOICE_ENTITY_TYPE_ID',
                'name' => 'Числовой код для сущности счетов в Битрикс24',
                'value' => '31'
            ],
            [
                'code' => 'TERMINAL_KEY',
                'name' => 'Идентификатор магазина для онлайн оплаты через терминал Т-Кассы',
                'value' => '1734786275434DEMO'
            ],
            [
                'code' => 'EMAIL_COMPANY',
                'name' => 'Email компании для оплаты через Т-Кассу',
                'value' => 'mail@mail.com'
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
