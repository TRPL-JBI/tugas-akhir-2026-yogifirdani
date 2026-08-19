<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tour_packages', function (Blueprint $table) {
            $table->id();
            $table->string('package_name');
            $table->string('slug')->unique();
            $table->string('package_type', 100);
            $table->foreignId('category_id')->constrained('categories');
            $table->integer('price_1pax')->nullable();
            $table->integer('price_2pax')->nullable();
            $table->integer('price_3pax')->nullable();
            $table->integer('price_4pax')->nullable();
            $table->integer('price_5pax')->nullable();
            $table->integer('price_8pax')->nullable();
            $table->integer('price_10pax')->nullable();
            $table->string('duration', 100);
            $table->text('destination')->nullable();
            $table->string('city');
            $table->text('description')->nullable();
            $table->text('meeting_point')->nullable();
            $table->text('daily_schedule')->nullable();
            $table->text('itinerary')->nullable();
            $table->text('persyaratan')->nullable();
            $table->text('facilities_included')->nullable();
            $table->text('facilities_excluded')->nullable();
            $table->integer('dp_days_before')->default(1);
            $table->text('payment')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tour_packages');
    }
};
