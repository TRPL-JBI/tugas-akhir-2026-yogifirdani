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
            $table->string('duration_en')->nullable()->after('duration');
        });

        // Copy existing duration to duration_en
        \DB::table('tour_packages')->update([
            'duration_en' => \DB::raw('duration')
        ]);
    }

    public function down(): void
    {
        Schema::table('tour_packages', function (Blueprint $table) {
            $table->dropColumn('duration_en');
        });
    }
};
