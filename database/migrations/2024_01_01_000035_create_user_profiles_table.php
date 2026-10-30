<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('user_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->unique()->constrained('users')->cascadeOnDelete();
            $table->string('location')->nullable();
            $table->string('company')->nullable();
            $table->string('position')->nullable();
            $table->text('bio_html')->nullable();
            $table->json('social_links')->nullable();
            $table->json('preferences')->nullable();
            $table->json('notification_preferences')->nullable();
            $table->string('theme')->nullable();
            $table->string('theme_preference')->nullable();
            $table->string('language', 12)->nullable();
            $table->string('timezone')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_profiles');
    }
};
