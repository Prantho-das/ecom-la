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
        Schema::table('quotation_items', function (Blueprint $table) {
            $table->integer('quantity')->default(1)->after('product_id');
            $table->string('uom')->default('UNIT')->after('quantity');
            $table->decimal('row_total', 16, 6)->default(0)->after('final_unit_price');
        });
    }

    public function down(): void
    {
        Schema::table('quotation_items', function (Blueprint $table) {
            $table->dropColumn(['quantity', 'uom', 'row_total']);
        });
    }
};
