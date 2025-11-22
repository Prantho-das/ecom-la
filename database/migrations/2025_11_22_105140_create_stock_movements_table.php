<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStockMovementsTable extends Migration
{
    public function up()
    {
        Schema::create('stock_movements', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('variant_id');
            $table->unsignedBigInteger('location_id');
            $table->enum('type', ['purchase', 'sale', 'adjustment', 'transfer_in', 'transfer_out', 'return', 'damage']);
            $table->integer('quantity_change');
            $table->string('reference_type', 50)->nullable();
            $table->unsignedBigInteger('reference_id')->nullable();
            $table->text('notes')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->timestamp('created_at')->useCurrent();

            $table->index(['variant_id', 'location_id'], 'idx_variant_loc');
            $table->index(['type', 'created_at'], 'idx_type_date');

            $table->foreign('variant_id')->references('id')->on('product_variants')->onDelete('cascade');
            $table->foreign('location_id')->references('id')->on('inventory_locations')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('stock_movements');
    }
}