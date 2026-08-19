<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('tour_packages', function (Blueprint $table) {
            $table->string('package_name_en')->nullable()->after('package_name');
            $table->text('description_en')->nullable()->after('description');
            $table->text('meeting_point_en')->nullable()->after('meeting_point');
            $table->text('daily_schedule_en')->nullable()->after('daily_schedule');
            $table->text('itinerary_en')->nullable()->after('itinerary');
            $table->text('persyaratan_en')->nullable()->after('persyaratan');
            $table->text('facilities_included_en')->nullable()->after('facilities_included');
            $table->text('facilities_excluded_en')->nullable()->after('facilities_excluded');
            $table->text('payment_en')->nullable()->after('payment');
        });

        Schema::table('categories', function (Blueprint $table) {
            $table->string('category_name_en')->nullable()->after('category_name');
            $table->text('description_en')->nullable()->after('description');
        });

        Schema::table('package_types', function (Blueprint $table) {
            $table->string('type_name_en')->nullable()->after('type_name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tour_packages', function (Blueprint $table) {
            $table->dropColumn([
                'package_name_en', 'description_en', 'meeting_point_en', 'daily_schedule_en',
                'itinerary_en', 'persyaratan_en', 'facilities_included_en', 'facilities_excluded_en', 'payment_en'
            ]);
        });

        Schema::table('categories', function (Blueprint $table) {
            $table->dropColumn(['category_name_en', 'description_en']);
        });

        Schema::table('package_types', function (Blueprint $table) {
            $table->dropColumn(['type_name_en']);
        });
    }
};
