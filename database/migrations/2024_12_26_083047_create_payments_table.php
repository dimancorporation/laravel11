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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->string('b24_deal_id')->nullable(); // айди сделки в битрикс24
            $table->string('b24_contact_id')->nullable(); // айди контакта в битрикс24
            $table->string('b24_invoice_id')->nullable(); // айди счета в битрикс24 к которому привязана оплата
            $table->string('order_id');
            $table->boolean('success')->default(false);
            //только уникальные комбинации Status + PaymentId
            $table->string('status')->default('NEW');
            $table->string('payment_id');
            $table->integer('amount');
            $table->integer('card_id');
            $table->string('email')->nullable();
            $table->string('name')->nullable();
            $table->string('phone');
            $table->string('source')->nullable();
            $table->string('user_agent')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
