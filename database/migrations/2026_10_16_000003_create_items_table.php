<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Repeatable content: topics, formats, engagements, organisations, FAQs, media, podcast episodes, resources…
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->string('type', 60)->index();
            $table->string('title', 300);
            $table->string('slug', 320)->nullable()->index();
            $table->string('subtitle', 300)->nullable();
            $table->text('body')->nullable();
            $table->string('icon', 40)->nullable();
            $table->string('image')->nullable();
            $table->string('file')->nullable();
            $table->string('url', 500)->nullable();
            $table->date('date')->nullable();
            $table->string('category', 60)->nullable();
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_published')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('items');
    }
};
