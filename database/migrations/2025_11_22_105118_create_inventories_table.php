<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInventoriesTable extends Migration
{
    public function up()
    {
        Schema::create('inventories', function (Blueprint $table) {
            $table->unsignedBigInteger('variant_id');
            $table->unsignedBigInteger('location_id');
            $table->integer('quantity')->default(0);
            $table->integer('reserved_quantity')->default(0);

            // MySQL generated column (available = quantity - reserved_quantity)
            $table->integer('available')->storedAs('quantity - reserved_quantity');

            $table->integer('reorder_level')->default(0);

            $table->primary(['variant_id', 'location_id']);

            $table->foreign('variant_id')->references('id')->on('product_variants')->onDelete('cascade');
            $table->foreign('location_id')->references('id')->on('inventory_locations')->onDelete('cascade');

            $table->index(['location_id', 'available'], 'idx_location_available');
        });
    }

    public function down()
    {
        Schema::dropIfExists('inventories');
    }
}
