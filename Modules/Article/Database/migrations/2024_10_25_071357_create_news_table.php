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
        Schema::create('news', function (Blueprint $table) {
            $table->id();

            $table->text('title')->fulltext();
            $table->text('slug');
            $table->text('url');
            $table->text('image_url')->nullable();
            $table->text('description')->nullable()->fulltext();
            $table->text('content')->nullable()->fulltext();
            $table->integer('source_id')->nullable();
            $table->tinyText('source_name')->nullable();
            $table->tinyText('authors_object')->nullable();
            $table->timestamp('published_at');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('news');
    }
};
