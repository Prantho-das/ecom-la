<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('brand_id')->nullable()->constrained('brands')->nullOnDelete();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('short_description')->nullable();
            $table->longText('description')->nullable();
            $table->enum('status', ['draft', 'active', 'archived'])->default('draft');
            $table->timestamp('published_at')->nullable();
            $table->json('metafields')->nullable();
            $table->json('tags')->nullable();
            $table->timestamps();

            $table->index('slug', 'idx_slug');
            $table->index(['status', 'published_at'], 'idx_status_published');
            // $table->fullText(['name', 'short_description', 'description'], 'idx_search');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
