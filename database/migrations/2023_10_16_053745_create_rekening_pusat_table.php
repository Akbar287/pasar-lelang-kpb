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
        Schema::create('rekening_pusat', function (Blueprint $table) {
            $table->uuid('rekening_pusat_id')->primary();
            $table->uuid('bank_id');
            $table->string('nomor_rekening', 32);
            $table->string('cabang', 32);
            $table->string('mata_uang', 8);
            $table->decimal('saldo', 19, 2);
            $table->boolean('aktif');
            $table->boolean('status');

            $table->foreign('bank_id')->references('bank_id')->on('bank')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rekening_pusat');
    }
};
