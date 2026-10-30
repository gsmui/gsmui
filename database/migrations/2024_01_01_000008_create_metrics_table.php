<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('metrics', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('type')->default('counter');
            $table->float('value');
            $table->json('dimensions')->nullable();
            $table->timestamp('recorded_at');
            $table->timestamps();
        });

        Schema::table('metrics', function (Blueprint $table) {
            $table->index(['name', 'recorded_at']);
            $table->index(['name', 'type']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('metrics');
    }
};
