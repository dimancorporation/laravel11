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
            $table->string('b24_status', 500)->nullable()->after('email'); // Статус сделки в битрикс24
            $table->string('link_to_court')->nullable()->after('b24_status'); // Ссылка на дело в арбитражном суде
            $table->decimal('sum_contract', 9, 0)->nullable()->after('link_to_court'); // Сумма договора
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['b24_status', 'link_to_court', 'sum_contract']);
        });
    }
};
