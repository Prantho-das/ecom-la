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
        Schema::create('solutions', function (Blueprint $table) {
            $table->id();
            $table->string('page_slug')->default('vertiv-home')->unique();

            // ==================== FIXED COLUMNS ====================
            $table->string('hero_title');
            $table->text('hero_subtitle');
            $table->string('hero_background_image')->nullable();
            $table->text('features_heading')->nullable();

            // ==================== DEDICATED JSON SECTIONS ====================
            $table->json('feature_cards_section')->nullable(); // 3 cards: Managing data security...
            $table->json('trends_section')->nullable();        // What's changing in logistics infrastructure
            $table->json('cta_section')->nullable();           // Rethink the roadmap for AI adoption

            // ==================== DYNAMIC REPEATABLE CONTENT ====================
            $table->json('sections'); // Only FAQs (fully repeatable)

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('solutions');
    }
};
