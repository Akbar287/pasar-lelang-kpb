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
        Schema::create('daftar_peserta_lelang_berlangsung_approval', function (Blueprint $table) {
            $table->uuid('daftar_peserta_lelang_berlangsung_id');
            $table->uuid('approval_lelang_id');
            $table->primary(['approval_lelang_id', 'daftar_peserta_lelang_berlangsung_id']);

            $table->foreign('daftar_peserta_lelang_berlangsung_id')->references('daftar_peserta_lelang_berlangsung_id')->on('daftar_peserta_lelang_berlangsung')->cascadeOnDelete();
            $table->foreign('approval_lelang_id')->references('approval_lelang_id')->on('approval_lelang')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('daftar_peserta_lelang_berlangsung_approval');
    }
};
