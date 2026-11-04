<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('testimonials', function (Blueprint $table) {
            $table->id();
            $table->text('quote');
            $table->string('name', 150);
            $table->string('role', 150)->nullable();
            $table->string('organisation', 150)->nullable();
            $table->string('context', 30)->default('general');
            $table->string('portrait')->nullable();
            $table->boolean('is_published')->default(false);
            $table->boolean('is_sample')->default(false);
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('testimonials');
    }
};
