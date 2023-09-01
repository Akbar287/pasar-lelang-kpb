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
        Schema::create('master_sesi_lelang', function (Blueprint $table) {
            $table->uuid('master_sesi_lelang_id')->primary();
            $table->uuid('penyelenggara_pasar_lelang_id');
            $table->string('sesi', 8);
            $table->time('jam_mulai');
            $table->time('jam_berakhir');
            $table->boolean('is_aktif');

            $table->foreign('penyelenggara_pasar_lelang_id')->references('penyelenggara_pasar_lelang_id')->on('penyelenggara_pasar_lelang')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('master_sesi_lelang');
    }
};
