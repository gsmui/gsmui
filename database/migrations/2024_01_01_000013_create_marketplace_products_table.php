<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('marketplace_products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users');
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description');
            $table->text('long_description')->nullable();
            $table->decimal('price', 8, 2);
            $table->decimal('compare_price', 8, 2)->nullable();
            $table->enum('type', ['digital', 'subscription', 'bundle']);
            $table->enum('status', ['draft', 'pending', 'published', 'rejected'])->default('draft');
            $table->integer('downloads_count')->default(0);
            $table->integer('reviews_count')->default(0);
            $table->decimal('rating_avg', 3, 2)->default(0);
            $table->decimal('commission_rate', 5, 2)->default(0);
            $table->boolean('featured')->default(false);
            $table->timestamps();
            $table->softDeletes();

            $table->index('status');
            $table->index('type');
            $table->index('featured');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('marketplace_products');
    }
};
