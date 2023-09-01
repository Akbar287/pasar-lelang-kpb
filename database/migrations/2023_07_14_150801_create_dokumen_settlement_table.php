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
        Schema::create('dokumen_settlement', function (Blueprint $table) {
            $table->uuid('dokumen_settlement_id')->primary();
            $table->date('tanggal_mulai');
            $table->date('tenggat_waktu');
            $table->decimal('nilai_kesepakatan', 18, 2);
            $table->decimal('nilai_tagihan_pembeli', 18, 2);
            $table->decimal('total_pembayaran_ke_penjual', 18, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dokumen_settlement');
    }
};
