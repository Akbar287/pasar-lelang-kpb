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
        Schema::create('dokumen_settlement_member', function (Blueprint $table) {
            $table->uuid('dokumen_settlement_id');
            $table->uuid('informasi_akun_id');
            $table->primary(['dokumen_settlement_id', 'informasi_akun_id']);

            $table->foreign('informasi_akun_id')->references('informasi_akun_id')->on('informasi_akun')->cascadeOnDelete();
            $table->foreign('dokumen_settlement_id')->references('dokumen_settlement_id')->on('dokumen_settlement')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dokumen_settlement_member');
    }
};
