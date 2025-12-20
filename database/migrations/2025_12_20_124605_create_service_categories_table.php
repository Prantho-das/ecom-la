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
        Schema::create('service_categories', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('short_description');
            $table->longText('full_description')->nullable();
            $table->string('image')->nullable(); // e.g., stored via FileUpload
            $table->string('feature_image')->nullable(); // e.g., stored via FileUpload
            $table->string('benefit_image')->nullable(); // e.g., stored via FileUpload
            $table->json('links')->nullable();
            $table->json('industries')->nullable();
            $table->json('features')->nullable();   // [{ "title": "...", "description": "..." }]
            $table->json('benefits')->nullable();   // same structure
            $table->json('related_services')->nullable(); // [1, 3, 5]
            $table->boolean('published')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('service_categories');
    }
};
