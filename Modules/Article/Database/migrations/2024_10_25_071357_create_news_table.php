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
            $table->tinyText('raw_author')->nullable();
            $table->text('title')->fulltext();
            $table->text('slug');
            $table->text('url');
            $table->text('image_url')->nullable();
            $table->text('description')->nullable()->fulltext();
            $table->text('content')->nullable()->fulltext();
            $table->string('api_source')->nullable();
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
