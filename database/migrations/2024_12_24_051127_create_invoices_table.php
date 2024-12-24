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
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->integer('b24_invoice_id');
            $table->integer('b24_payment_type_id');
            $table->string('b24_payment_type_name');
            $table->timestamps();
            $table->string('title');
            $table->timestamp('created_time')->nullable();
            $table->timestamp('updated_time')->nullable();
            $table->timestamp('moved_time')->nullable();
            $table->integer('category_id');
            $table->string('stage_id')->nullable();
            $table->string('previous_stage_id')->nullable();
            $table->timestamp('begin_date')->nullable();
            $table->timestamp('close_date')->nullable();
            $table->integer('contact_id');
            $table->string('opportunity')->nullable();
            $table->string('is_manual_opportunity');
            $table->string('currency_id');

            $table->index(['title']);
            $table->index(['opportunity']);
            $table->index(['stage_id']);
            $table->index(['contact_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
