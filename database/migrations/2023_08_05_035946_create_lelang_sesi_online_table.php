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
        Schema::create('lelang_sesi_online', function (Blueprint $table) {
            $table->uuid('lelang_sesi_online_id')->primary();
            $table->uuid('lelang_id');
            $table->uuid('master_sesi_lelang_id');
            $table->date('tanggal');
            $table->boolean('is_verification_admin');
            $table->timestamps();

            $table->foreign('master_sesi_lelang_id')->references('master_sesi_lelang_id')->on('master_sesi_lelang')->cascadeOnDelete();
            $table->foreign('lelang_id')->references('lelang_id')->on('lelang')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lelang_sesi_online');
    }
};
