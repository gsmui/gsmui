<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('templates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('author_id')->constrained('users');
            $table->foreignId('category_id')->nullable();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description');
            $table->string('status')->default('draft');
            $table->boolean('is_free')->default(true);
            $table->boolean('is_premium')->default(false);
            $table->decimal('price', 8, 2)->nullable();
            $table->string('preview_image')->nullable();
            $table->string('demo_url')->nullable();
            $table->string('download_url')->nullable();
            $table->string('version')->default('1.0.0');
            $table->json('changelog')->nullable();
            $table->json('tags')->nullable();
            $table->integer('downloads_count')->default(0);
            $table->float('rating')->default(0);
            $table->integer('rating_count')->default(0);
            $table->boolean('is_featured')->default(false);
            $table->string('framework')->nullable();
            $table->string('industry')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('templates');
    }
};
