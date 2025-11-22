<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('product_variants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained('products')->cascadeOnDelete();
            $table->string('sku', 100)->unique();
            $table->string('title');
            $table->decimal('price', 16, 6)->default(0);
            $table->decimal('compare_at_price', 16, 6)->nullable();
            $table->decimal('cost_price', 16, 6)->nullable();
            $table->string('barcode', 100)->nullable();
            $table->decimal('weight', 10, 2)->nullable();
            $table->boolean('track_inventory')->default(true);
            $table->boolean('continue_selling_when_out')->default(false);
            $table->timestamps();

            $table->index('sku', 'idx_sku');
            $table->index('price', 'idx_price');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('product_variants');
    }
};
