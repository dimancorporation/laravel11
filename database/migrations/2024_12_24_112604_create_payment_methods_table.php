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
        Schema::create('payment_methods', function (Blueprint $table) {
            $table->id();
            $table->string('b24_payment_type_id')->unique(); // Уникальный код типа оплаты
            $table->string('b24_payment_type_name')->unique(); // Название типа оплаты
            $table->timestamps();
        });

        $data = [
            ['b24_payment_type_id' => '269', 'b24_payment_type_name' => 'Наличные'],
            ['b24_payment_type_id' => '271', 'b24_payment_type_name' => 'На расчетный счет компании'],
            ['b24_payment_type_id' => '273', 'b24_payment_type_name' => 'Оплата на карту']
        ];
        foreach ($data as $item) {
            DB::table('payment_methods')->insert($item);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_methods');
    }
};
