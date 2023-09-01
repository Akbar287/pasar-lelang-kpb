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
        Schema::create('perubahan_event_lelang', function (Blueprint $table) {
            $table->uuid('perubahan_event_lelang_id')->primary();
            $table->uuid('event_lelang_id');
            $table->uuid('informasi_akun_id');
            $table->date('tanggal_perubahan');

            $table->foreign('informasi_akun_id')->references('informasi_akun_id')->on('informasi_akun')->cascadeOnDelete();
            $table->foreign('event_lelang_id')->references('event_lelang_id')->on('event_lelang')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('perubahan_event_lelang');
    }
};
