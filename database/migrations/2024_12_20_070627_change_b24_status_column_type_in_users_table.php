<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement("ALTER TABLE users ALTER COLUMN b24_status TYPE smallint USING b24_status::smallint");
        DB::statement("ALTER TABLE users ALTER COLUMN b24_status SET DEFAULT 1");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("ALTER TABLE users ALTER COLUMN b24_status TYPE varchar USING b24_status::varchar");
        DB::statement("ALTER TABLE users ALTER COLUMN b24_status DROP DEFAULT");
    }
};
