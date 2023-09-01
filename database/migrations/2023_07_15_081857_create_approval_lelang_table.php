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
        Schema::create('approval_lelang', function (Blueprint $table) {
            $table->uuid('approval_lelang_id')->primary();
            $table->uuid('informasi_akun_id');
            $table->uuid('jenis_harga_id');
            $table->uuid('verified_log_id');
            $table->decimal('harga_pemenang', 18, 2);
            $table->timestamps();

            $table->foreign('informasi_akun_id')->references('informasi_akun_id')->on('informasi_akun')->cascadeOnDelete();
            $table->foreign('jenis_harga_id')->references('jenis_harga_id')->on('jenis_harga')->cascadeOnDelete();
            $table->foreign('verified_log_id')->references('verified_log_id')->on('verified_log')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('approval_lelang');
    }
};
