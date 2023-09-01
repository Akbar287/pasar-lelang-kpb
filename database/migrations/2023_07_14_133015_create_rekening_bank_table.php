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
        Schema::create('rekening_bank', function (Blueprint $table) {
            $table->uuid('rekening_bank_id')->primary();
            $table->uuid('informasi_akun_id');
            $table->uuid('bank_id');
            $table->string('nomor_rekening', 32);
            $table->string('nama_pemilik', 128);
            $table->string('cabang', 128);
            $table->string('mata_uang', 8);
            $table->decimal('nilai_awal', 18, 2);
            $table->decimal('saldo', 18, 2);
            $table->timestamps();

            $table->foreign('informasi_akun_id')->references('informasi_akun_id')->on('informasi_akun')->cascadeOnDelete();
            $table->foreign('bank_id')->references('bank_id')->on('bank')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rekening_bank');
    }
};
