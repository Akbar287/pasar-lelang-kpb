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
        Schema::create('blog_post_kategori', function (Blueprint $table) {
            $table->uuid('blog_post_id');
            $table->uuid('blog_kategori_id');

            $table->foreign('blog_post_id')->references('blog_post_id')->on('blog_post')->cascadeOnDelete();
            $table->foreign('blog_kategori_id')->references('blog_kategori_id')->on('blog_kategori')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('blog_post_kategori');
    }
};
