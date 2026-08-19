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
            $table->decimal('price_1pax_foreign', 15, 2)->nullable()->after('price_1pax');
            $table->decimal('price_2pax_foreign', 15, 2)->nullable()->after('price_2pax');
            $table->decimal('price_3pax_foreign', 15, 2)->nullable()->after('price_3pax');
            $table->decimal('price_4pax_foreign', 15, 2)->nullable()->after('price_4pax');
            $table->decimal('price_5pax_foreign', 15, 2)->nullable()->after('price_5pax');
            $table->decimal('price_8pax_foreign', 15, 2)->nullable()->after('price_8pax');
            $table->decimal('price_10pax_foreign', 15, 2)->nullable()->after('price_10pax');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tour_packages', function (Blueprint $table) {
            $table->dropColumn([
                'price_1pax_foreign',
                'price_2pax_foreign',
                'price_3pax_foreign',
                'price_4pax_foreign',
                'price_5pax_foreign',
                'price_8pax_foreign',
                'price_10pax_foreign',
            ]);
        });
    }
};
