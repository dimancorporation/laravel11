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
        Schema::rename('constants', 'b24_user_fields');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::rename('b24_user_fields', 'constants');
    }
};
