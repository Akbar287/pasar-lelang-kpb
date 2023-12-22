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
        Schema::create('notifikasi', function (Blueprint $table) {
            $table->uuid('notifikasi_id')->primary();
            $table->uuid('informasi_akun_id');
            $table->string('judul');
            $table->string('konten');
            $table->string('is_read');
            $table->timestamps();

            $table->foreign('informasi_akun_id')->references('informasi_akun_id')->on('informasi_akun')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifikasi');
    }
};
