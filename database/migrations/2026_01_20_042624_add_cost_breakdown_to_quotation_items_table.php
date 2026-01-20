<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('quotation_items', function (Blueprint $table) {
            // Product specifications for shipping calculation
            $table->decimal('weight_kg', 10, 2)->nullable()->after('quantity')->comment('Weight in KG');
            $table->decimal('volume_cbm', 10, 4)->nullable()->after('weight_kg')->comment('Volume in CBM (Cubic Meters)');
            $table->decimal('unit_product_price', 16, 6)->default(0)->after('price')->comment('Original product price before costs');

            // Cost breakdown per item (matching Excel columns)
            $table->decimal('export_freight', 16, 6)->default(0)->after('unit_product_price');
            $table->decimal('export_clearance', 16, 6)->default(0)->after('export_freight');
            $table->decimal('origin_handling', 16, 6)->default(0)->after('export_clearance');
            $table->decimal('international_freight', 16, 6)->default(0)->after('origin_handling');
            $table->decimal('insurance', 16, 6)->default(0)->after('international_freight');
            $table->decimal('import_duties', 16, 6)->default(0)->after('insurance');
            $table->decimal('handling_charges', 16, 6)->default(0)->after('import_duties');
            $table->decimal('inland_transport', 16, 6)->default(0)->after('handling_charges');

            // Calculated prices
            $table->decimal('cost_factor', 16, 6)->default(0)->after('inland_transport')->comment('Sum of all costs per unit');
            $table->decimal('unit_price_with_costs', 16, 6)->default(0)->after('cost_factor')->comment('Base price + all costs');
            $table->decimal('unit_price_with_margin', 16, 6)->default(0)->after('unit_price_with_costs')->comment('With margin applied');
            $table->decimal('final_unit_price', 16, 6)->default(0)->after('unit_price_with_margin')->comment('Final price with tax & VAT');
        });
    }

    public function down(): void
    {
        Schema::table('quotation_items', function (Blueprint $table) {
            $table->dropColumn([
                'weight_kg',
                'volume_cbm',
                'unit_product_price',
                'export_freight',
                'export_clearance',
                'origin_handling',
                'international_freight',
                'insurance',
                'import_duties',
                'handling_charges',
                'inland_transport',
                'cost_factor',
                'unit_price_with_costs',
                'unit_price_with_margin',
                'final_unit_price',
            ]);
        });
    }
};
