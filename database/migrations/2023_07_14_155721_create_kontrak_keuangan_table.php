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
        Schema::create('kontrak_keuangan', function (Blueprint $table) {
            $table->uuid('kontrak_keuangan_id')->primary();
            $table->uuid('kontrak_id');
            $table->decimal('jaminan_lelang', 18, 2);
            $table->decimal('denda', 18, 2);
            $table->decimal('fee_penjual', 18, 2);
            $table->decimal('fee_pembeli', 18, 2);

            $table->foreign('kontrak_id')->references('kontrak_id')->on('kontrak')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kontrak_keuangan');
    }
};
