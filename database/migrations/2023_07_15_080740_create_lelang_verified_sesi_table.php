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
        Schema::create('lelang_verified_sesi', function (Blueprint $table) {
            $table->uuid('lelang_verified_sesi_id')->primary();
            $table->uuid('lelang_id');
            $table->uuid('verified_log_id');
            $table->timestamps();

            $table->foreign('lelang_id')->references('lelang_id')->on('lelang')->cascadeOnDelete();
            $table->foreign('verified_log_id')->references('verified_log_id')->on('verified_log')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lelang_verified_sesi');
    }
};
