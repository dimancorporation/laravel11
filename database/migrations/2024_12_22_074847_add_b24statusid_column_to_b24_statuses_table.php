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
        Schema::table('b24_statuses', function (Blueprint $table) {
            $table->unsignedBigInteger('b24StatusId')->nullable()->after('name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('b24_statuses', function (Blueprint $table) {
            $table->dropColumn('b24StatusId');
        });
    }
};
