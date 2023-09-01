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
        Schema::create('opsi_pembayaran_lelang', function (Blueprint $table) {
            $table->uuid('opsi_pembayaran_lelang_id')->primary();
            $table->uuid('informasi_akun_id');
            $table->uuid('pembayaran_lelang_id');
            $table->uuid('jenis_opsi_pembayaran_lelang_id');
            $table->enum('jenis_informasi_akun', ['seller', 'buyer']);
            $table->decimal('tagihan', 18, 2);
            $table->decimal('biaya_lain_lain_penjual', 18, 2);
            $table->decimal('penyelesaian', 18, 2);

            $table->foreign('informasi_akun_id')->references('informasi_akun_id')->on('informasi_akun')->cascadeOnDelete();
            $table->foreign('jenis_opsi_pembayaran_lelang_id')->references('jenis_opsi_pembayaran_lelang_id')->on('jenis_opsi_pembayaran_lelang')->cascadeOnDelete();
            $table->foreign('pembayaran_lelang_id')->references('pembayaran_lelang_id')->on('pembayaran_lelang')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('opsi_pembayaran_lelang');
    }
};
