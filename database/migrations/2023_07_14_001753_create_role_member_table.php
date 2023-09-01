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
        Schema::create('role_member', function (Blueprint $table) {
            $table->uuid('role_id');
            $table->uuid('member_id');
            $table->primary(['role_id', 'member_id']);

            $table->foreign('member_id')->references('member_id')->on('member')->cascadeOnDelete();
            $table->foreign('role_id')->references('role_id')->on('role')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('role_member');
    }
};
