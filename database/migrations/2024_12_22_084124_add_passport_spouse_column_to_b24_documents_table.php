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
        Schema::table('b24_documents', function (Blueprint $table) {
            $table->boolean('passport_spouse')->default(false)->after('marriage_certificate');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('b24_documents', function (Blueprint $table) {
            $table->dropColumn('passport_spouse');
        });
    }
};
