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
        Schema::create('release_cash_dokumen_settlement', function (Blueprint $table) {
            $table->uuid('release_cash_id');
            $table->uuid('dokumen_settlement_id');

            $table->primary(['release_cash_id', 'dokumen_settlement_id']);

            $table->foreign('release_cash_id')->references('release_cash_id')->on('release_cash')->cascadeOnDelete();
            $table->foreign('dokumen_settlement_id')->references('dokumen_settlement_id')->on('dokumen_settlement')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('release_cash_dokumen_settlement');
    }
};
