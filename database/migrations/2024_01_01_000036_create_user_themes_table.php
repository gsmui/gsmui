<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('user_themes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('theme_id')->constrained('themes')->cascadeOnDelete();
            $table->timestamp('installed_at')->nullable();
            $table->timestamps();

            $table->unique(['user_id', 'theme_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_themes');
    }
};
