<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('licenses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('product_id')->constrained('marketplace_products');
            $table->foreignId('order_id')->constrained('orders');
            $table->string('license_key')->unique();
            $table->enum('status', ['active', 'expired', 'revoked'])->default('active');
            $table->timestamp('activated_at')->nullable();
            $table->timestamp('expires_at')->nullable();
            $table->integer('activations_count')->default(0);
            $table->integer('max_activations')->default(5);
            $table->timestamps();

            $table->index('status');
            $table->index(['user_id', 'product_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('licenses');
    }
};
