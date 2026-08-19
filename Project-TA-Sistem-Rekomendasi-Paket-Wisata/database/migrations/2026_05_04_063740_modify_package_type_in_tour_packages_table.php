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
            $table->dropColumn('package_type');
            $table->foreignId('package_type_id')->nullable()->after('slug')->constrained('package_types')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tour_packages', function (Blueprint $table) {
            $table->dropForeign(['package_type_id']);
            $table->dropColumn('package_type_id');
            $table->string('package_type')->after('slug');
        });
    }
};
