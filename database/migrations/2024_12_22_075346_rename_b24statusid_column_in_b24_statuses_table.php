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
            $table->renameColumn('b24StatusId', 'b24_status_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('b24_statuses', function (Blueprint $table) {
            $table->renameColumn('b24_status_id', 'b24StatusId');
        });
    }
};
