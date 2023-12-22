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
        Schema::create('blog_post_meta', function (Blueprint $table) {
            $table->uuid('blog_post_meta_id')->primary();
            $table->uuid('blog_post_id');
            $table->string('key', 32);
            $table->text('content');

            $table->foreign('blog_post_id')->references('blog_post_id')->on('blog_post')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('blog_post_meta');
    }
};
