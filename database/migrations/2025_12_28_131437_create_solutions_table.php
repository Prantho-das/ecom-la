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

            // ========= FIXED CONTENT (regular columns) =========
            $table->string('hero_title');
            $table->text('hero_subtitle');
            $table->string('hero_background_image')->nullable();
            $table->text('features_heading')->nullable();
            $table->string('trends_heading')->default("What's changing in logistics infrastructure"); // Fixed header for trends
            $table->string('faqs_heading')->default("FAQs");        // Fixed header for FAQs
            $table->json('features_grid_section')->nullable();  // 3 feature cards only (no heading)
            $table->json('trends_items_section')->nullable();   // Only the 3 trend items (icon, title, description)
            $table->json('cta_image_section')->nullable();      // Full CTA section
            $table->json('faqs_items_section')->nullable();     // Only FAQ items (question + answer)

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
