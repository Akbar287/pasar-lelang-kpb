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
        Schema::create('suspend', function (Blueprint $table) {
            $table->uuid('suspend_id')->primary();
            $table->uuid('verified_log_id');
            $table->uuid('suspend_type_id');
            $table->string('suspend_kode', 32);
            $table->date('tanggal_suspend');
            $table->date('tanggal_reaktivasi')->nullable();

            $table->foreign('verified_log_id')->references('verified_log_id')->on('verified_log')->cascadeOnDelete();
            $table->foreign('suspend_type_id')->references('suspend_type_id')->on('suspend_type')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('suspend');
    }
};
