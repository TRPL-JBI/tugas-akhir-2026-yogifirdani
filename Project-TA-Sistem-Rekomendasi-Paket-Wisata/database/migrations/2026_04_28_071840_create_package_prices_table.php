<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('package_prices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('package_id')->constrained('tour_packages');
            $table->decimal('pax1', 15, 2)->default(0);
            $table->decimal('pax2', 15, 2)->default(0);
            $table->decimal('pax3', 15, 2)->default(0);
            $table->decimal('pax4', 15, 2)->default(0);
            $table->decimal('pax5', 15, 2)->default(0);
            $table->decimal('pax6', 15, 2)->default(0);
            $table->decimal('pax7', 15, 2)->default(0);
            $table->decimal('pax8', 15, 2)->default(0);
            $table->decimal('pax9', 15, 2)->default(0);
            $table->decimal('pax10', 15, 2)->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('package_prices');
    }
};
