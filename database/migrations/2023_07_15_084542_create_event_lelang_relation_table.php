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
        Schema::create('event_lelang_relation', function (Blueprint $table) {
            $table->uuid('event_lelang_id');
            $table->uuid('lelang_id');
            $table->primary(['event_lelang_id', 'lelang_id']);

            $table->foreign('lelang_id')->references('lelang_id')->on('lelang')->cascadeOnDelete();
            $table->foreign('event_lelang_id')->references('event_lelang_id')->on('event_lelang')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('event_lelang_relation');
    }
};
