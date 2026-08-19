<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->string('booking_code')->unique();
            $table->foreignId('package_id')->constrained('tour_packages');
            $table->integer('num_participants');
            $table->date('booking_date');
            $table->date('trip_date');
            $table->float('total_price');
            $table->float('dp_amount');
            $table->float('remaining_amount');
            $table->string('payment_status', 50)->default('pending');
            $table->string('booking_status', 50)->default('pending');
            $table->string('customer_name');
            $table->string('customer_phone', 50);
            $table->string('customer_email');
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
