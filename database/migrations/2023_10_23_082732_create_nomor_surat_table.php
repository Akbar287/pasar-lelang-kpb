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
        Schema::create('nomor_surat', function (Blueprint $table) {
            $table->uuid('nomor_surat_id')->primary();
            $table->uuid('approval_lelang_id');
            $table->string('no_surat', 32);

            $table->foreign('approval_lelang_id')->references('approval_lelang_id')->on('approval_lelang')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nomor_surat');
    }
};
