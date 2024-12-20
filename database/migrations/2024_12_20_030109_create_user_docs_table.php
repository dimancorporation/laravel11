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
        Schema::create('documents', function (Blueprint $table) {
            $table->id();
            $table->boolean('passport_all_pages')->default(false);
            $table->boolean('pts')->default(false);
            $table->boolean('scan_inn')->default(false);
            $table->boolean('snils')->default(false);
            $table->boolean('marriage_certificate')->default(false);
            $table->boolean('snils_spouse')->default(false);
            $table->boolean('divorce_certificate')->default(false);
            $table->boolean('ndfl')->default(false);
            $table->boolean('childrens_birth_certificate')->default(false);
            $table->boolean('extract_egrn')->default(false);
            $table->boolean('scan_pts')->default(false);
            $table->boolean('sts')->default(false);
            $table->boolean('pts_spouse')->default(false);
            $table->boolean('sts_spouse')->default(false);
            $table->boolean('dkp')->default(false);
            $table->boolean('dkp_spouse')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('documents');
    }
};
