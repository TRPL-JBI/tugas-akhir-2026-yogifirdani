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
        if (!Schema::hasTable('package_vectors')) {
            Schema::create('package_vectors', function (Blueprint $table) {
                $table->id();
                $table->foreignId('package_id')->constrained('tour_packages')->onDelete('cascade');
                $table->text('combined_features')->nullable();
                $table->json('tfidf_vector')->nullable();
                $table->string('vocabulary_hash', 64)->nullable();
                $table->timestamp('last_updated')->useCurrent()->useCurrentOnUpdate();
                
                // Menggantikan UNIQUE KEY package_vectors_package_id_unique
                $table->unique('package_id');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('package_vectors');
    }
};
