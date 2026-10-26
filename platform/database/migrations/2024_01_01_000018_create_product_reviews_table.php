<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('product_reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('product_id')->constrained('marketplace_products');
            $table->foreignId('order_id')->constrained('orders');
            $table->tinyInteger('rating')->unsigned();
            $table->string('title');
            $table->text('body');
            $table->integer('helpful_count')->default(0);
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->timestamps();

            $table->index('status');
            $table->index(['product_id', 'status']);
            $table->index(['user_id', 'product_id'], 'unique_review', 'unique');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('product_reviews');
    }
};
