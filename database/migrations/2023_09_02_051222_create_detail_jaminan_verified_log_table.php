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
        Schema::create('detail_jaminan_verified_log', function (Blueprint $table) {
            $table->uuid('detail_jaminan_id');
            $table->uuid('verified_log_id');

            $table->primary(['detail_jaminan_id', 'verified_log_id']);

            $table->foreign('detail_jaminan_id')->references('detail_jaminan_id')->on('detail_jaminan')->cascadeOnDelete();
            $table->foreign('verified_log_id')->references('verified_log_id')->on('verified_log')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_jaminan_verified_log');
    }
};
