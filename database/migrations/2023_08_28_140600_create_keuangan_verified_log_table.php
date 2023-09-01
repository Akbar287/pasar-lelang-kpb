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
        Schema::create('keuangan_verified_log', function (Blueprint $table) {
            $table->uuid('keuangan_id');
            $table->uuid('verified_log_id');
            $table->primary(['keuangan_id', 'verified_log_id']);

            $table->foreign('keuangan_id')->references('keuangan_id')->on('keuangan')->cascadeOnDelete();
            $table->foreign('verified_log_id')->references('verified_log_id')->on('verified_log')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('keuangan_verified_log');
    }
};
