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
        Schema::create('peserta_lelang_aktif', function (Blueprint $table) {
            $table->uuid('peserta_lelang_aktif_id')->primary();
            $table->uuid('master_sesi_lelang_id');
            $table->uuid('lelang_sesi_online_id');
            $table->uuid('lelang_id');
            $table->date('waktu_mulai');
            $table->date('waktu_selesai');
            $table->boolean('aktif')->default(false);

            $table->foreign('master_sesi_lelang_id')->references('master_sesi_lelang_id')->on('master_sesi_lelang')->cascadeOnDelete();
            $table->foreign('lelang_sesi_online_id')->references('lelang_sesi_online_id')->on('lelang_sesi_online')->cascadeOnDelete();
            $table->foreign('lelang_id')->references('lelang_id')->on('lelang')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('peserta_lelang_aktif');
    }
};
