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
        Schema::create('member', function (Blueprint $table) {
            $table->uuid('member_id')->primary();
            $table->uuid('status_member_id');
            $table->uuid('informasi_akun_id');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('status_member_id')->references('status_member_id')->on('status_member')->cascadeOnDelete();
            $table->foreign('informasi_akun_id')->references('informasi_akun_id')->on('informasi_akun')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('member');
    }
};
