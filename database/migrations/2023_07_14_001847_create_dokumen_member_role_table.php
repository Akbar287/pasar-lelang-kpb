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
        Schema::create('jenis_dokumen_member_role', function (Blueprint $table) {
            $table->uuid('jenis_dokumen_id');
            $table->uuid('role_id');
            $table->primary(['jenis_dokumen_id', 'role_id']);

            $table->foreign('role_id')->references('role_id')->on('role')->cascadeOnDelete();
            $table->foreign('jenis_dokumen_id')->references('jenis_dokumen_id')->on('jenis_dokumen')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jenis_dokumen_member_role');
    }
};
