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
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('short_description');
            $table->longText('full_description')->nullable();
            $table->string('image')->nullable();
            $table->string('feature_image')->nullable();
            $table->string('benefit_image')->nullable();
            $table->json('links')->nullable();
            $table->json('industries')->nullable();
            $table->json('features')->nullable();
            $table->json('benefits')->nullable();
            $table->json('related_solutions')->nullable();
            $table->boolean('published')->default(true);
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
