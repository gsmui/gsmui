<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('showcase_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users');
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('description');
            $table->text('body');
            $table->string('thumbnail')->nullable();
            $table->json('gallery')->nullable();
            $table->string('category')->nullable();
            $table->json('tags')->nullable();
            $table->integer('likes_count')->default(0);
            $table->integer('comments_count')->default(0);
            $table->enum('status', ['draft', 'published'])->default('draft');
            $table->boolean('featured')->default(false);
            $table->timestamps();
            $table->softDeletes();

            $table->index('status');
            $table->index('category');
            $table->index('featured');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('showcase_items');
    }
};
