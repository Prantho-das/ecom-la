<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('product_variants', function (Blueprint $table) {
            $table->decimal('weight_kg', 10, 2)->nullable()->after('weight')->comment('Weight in kilograms');
            $table->decimal('volume_cbm', 10, 4)->nullable()->after('weight_kg')->comment('Volume in cubic meters');
            $table->decimal('length_cm', 10, 2)->nullable()->after('volume_cbm')->comment('Length in centimeters');
            $table->decimal('width_cm', 10, 2)->nullable()->after('length_cm')->comment('Width in centimeters');
            $table->decimal('height_cm', 10, 2)->nullable()->after('width_cm')->comment('Height in centimeters');
        });
    }

    public function down(): void
    {
        Schema::table('product_variants', function (Blueprint $table) {
            $table->dropColumn([
                'weight_kg',
                'volume_cbm',
                'length_cm',
                'width_cm',
                'height_cm',
            ]);
        });
    }
};
