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
        Schema::create('jaminan', function (Blueprint $table) {
            $table->uuid('jaminan_id')->primary();
            $table->uuid('informasi_akun_id');
            $table->decimal('total_saldo_jaminan', 18, 2);
            $table->decimal('saldo_teralokasi', 18, 2);
            $table->decimal('saldo_tersedia', 18, 2);

            $table->foreign('informasi_akun_id')->references('informasi_akun_id')->on('informasi_akun')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jaminan');
    }
};
