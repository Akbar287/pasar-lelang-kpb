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
        Schema::create('jaminan_komoditas_dokumen_settlement', function (Blueprint $table) {
            $table->uuid('jaminan_komoditas_id');
            $table->uuid('dokumen_settlement_id');

            $table->primary(['jaminan_komoditas_id', 'dokumen_settlement_id']);

            $table->foreign('jaminan_komoditas_id')->references('jaminan_komoditas_id')->on('jaminan_komoditas')->cascadeOnDelete();
            $table->foreign('dokumen_settlement_id')->references('dokumen_settlement_id')->on('dokumen_settlement')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jaminan_komoditas_dokumen_settlement');
    }
};
