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
        Schema::create('quotations', function (Blueprint $table) {
            $table->id();
            $table->string('customer_name');
            $table->string('customer_email');
            $table->enum('status', ['draft', 'sent', 'accepted', 'rejected', 'expired'])->default('draft');
            $table->decimal('subtotal', 16, 6)->default(0);
            $table->decimal('discount_total', 16, 6)->default(0);
            $table->decimal('tax_total', 16, 6)->default(0);
            $table->decimal('grand_total', 16, 6)->default(0);
            $table->text('notes')->nullable();
            $table->timestamp('expires_at')->nullable();
            $table->timestamps();
        });
        Schema::create('quotation_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('quotation_id')->constrained()->onDelete('cascade');
            $table->foreignId('variant_id')->constrained('product_variants')->onDelete('restrict');
            $table->string('name');
            $table->string('sku');
            $table->integer('quantity')->default(1);
            $table->decimal('price', 16, 6);
            $table->decimal('row_total', 16, 6);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quotations');
    }
};
