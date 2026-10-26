<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('search_index', function (Blueprint $table) {
            $table->id();
            $table->string('searchable_type');
            $table->unsignedBigInteger('searchable_id');
            $table->string('title');
            $table->text('body')->nullable();
            $table->json('keywords')->nullable();
            $table->float('rank')->default(1.0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::table('search_index', function (Blueprint $table) {
            $table->index(['searchable_type', 'searchable_id']);
            $table->index(['title', 'is_active']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('search_index');
    }
};
