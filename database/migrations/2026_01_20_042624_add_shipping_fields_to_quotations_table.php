<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('quotations', function (Blueprint $table) {
            // Shipping and pricing configuration
            $table->enum('shipping_method', ['sea', 'air'])->default('sea')->after('customer_email');
            $table->enum('pricing_tier', ['exwork', 'fob', 'cfr', 'cif', 'ddu_dap', 'ddp', 'bdt_local'])->default('exwork')->after('shipping_method');
            $table->string('currency', 10)->default('USD')->after('pricing_tier');
            $table->decimal('conversion_rate', 10, 4)->default(125)->after('currency')->comment('Currency to BDT conversion rate');
            $table->decimal('margin_percentage', 8, 2)->default(30)->after('conversion_rate')->comment('Profit margin percentage');
            $table->decimal('tax_percentage', 8, 4)->default(0.05)->after('margin_percentage')->comment('Tax percentage (5%)');
            $table->decimal('vat_percentage', 8, 4)->default(0.10)->after('tax_percentage')->comment('VAT percentage (10%)');

            // Cost breakdown totals
            $table->decimal('export_freight_total', 16, 6)->default(0)->after('subtotal');
            $table->decimal('export_clearance_total', 16, 6)->default(0)->after('export_freight_total');
            $table->decimal('origin_handling_total', 16, 6)->default(0)->after('export_clearance_total');
            $table->decimal('international_freight_total', 16, 6)->default(0)->after('origin_handling_total');
            $table->decimal('insurance_total', 16, 6)->default(0)->after('international_freight_total');
            $table->decimal('import_duties_total', 16, 6)->default(0)->after('insurance_total');
            $table->decimal('handling_charges_total', 16, 6)->default(0)->after('import_duties_total');
            $table->decimal('inland_transport_total', 16, 6)->default(0)->after('handling_charges_total');
            $table->decimal('cost_factor', 16, 6)->default(0)->after('inland_transport_total')->comment('Total cost factor per unit');
            $table->decimal('unit_price_with_margin', 16, 6)->default(0)->after('cost_factor');
        });
    }

    public function down(): void
    {
        Schema::table('quotations', function (Blueprint $table) {
            $table->dropColumn([
                'shipping_method',
                'pricing_tier',
                'currency',
                'conversion_rate',
                'margin_percentage',
                'tax_percentage',
                'vat_percentage',
                'export_freight_total',
                'export_clearance_total',
                'origin_handling_total',
                'international_freight_total',
                'insurance_total',
                'import_duties_total',
                'handling_charges_total',
                'inland_transport_total',
                'cost_factor',
                'unit_price_with_margin',
            ]);
        });
    }
};
