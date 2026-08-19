<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('user_preferences', function (Blueprint $table) {
            $table->id();
            $table->string('session_id')->unique();
            $table->foreignId('category_id')->nullable()->constrained('categories');
            $table->float('budget')->nullable();
            $table->string('preferred_duration', 100)->nullable();
            $table->text('preferred_facilities')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_preferences');
    }
};
