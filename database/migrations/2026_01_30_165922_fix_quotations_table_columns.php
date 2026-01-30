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
        Schema::table('quotations', function (Blueprint $table) {
            if (! Schema::hasColumn('quotations', 'customer_email')) {
                $table->string('customer_email')->after('customer_name')->nullable();
            }
            if (! Schema::hasColumn('quotations', 'quotation_date')) {
                $table->date('quotation_date')->after('customer_name')->nullable();
            }
            if (! Schema::hasColumn('quotations', 'shipping_method')) {
                $table->string('shipping_method')->default('sea')->after('customer_email');
            }
            if (! Schema::hasColumn('quotations', 'pricing_tier')) {
                $table->string('pricing_tier')->default('exwork')->after('shipping_method');
            }
            if (! Schema::hasColumn('quotations', 'currency')) {
                $table->string('currency', 10)->default('USD')->after('pricing_tier');
            }
            if (! Schema::hasColumn('quotations', 'conversion_rate')) {
                $table->decimal('conversion_rate', 10, 4)->default(125)->after('currency');
            }
            if (! Schema::hasColumn('quotations', 'margin_percentage')) {
                $table->decimal('margin_percentage', 8, 2)->default(30)->after('conversion_rate');
            }
            if (! Schema::hasColumn('quotations', 'tax_percentage')) {
                $table->decimal('tax_percentage', 8, 4)->default(0.05)->after('margin_percentage');
            }
            if (! Schema::hasColumn('quotations', 'vat_percentage')) {
                $table->decimal('vat_percentage', 8, 4)->default(0.10)->after('tax_percentage');
            }
            if (! Schema::hasColumn('quotations', 'subtotal')) {
                $table->decimal('subtotal', 16, 6)->default(0);
            }
            if (! Schema::hasColumn('quotations', 'discount_total')) {
                $table->decimal('discount_total', 16, 6)->default(0);
            }
            if (! Schema::hasColumn('quotations', 'tax_total')) {
                $table->decimal('tax_total', 16, 6)->default(0);
            }
            if (! Schema::hasColumn('quotations', 'grand_total')) {
                $table->decimal('grand_total', 16, 6)->default(0);
            }
            if (! Schema::hasColumn('quotations', 'export_freight_total')) {
                $table->decimal('export_freight_total', 16, 6)->default(0);
            }
            if (! Schema::hasColumn('quotations', 'export_clearance_total')) {
                $table->decimal('export_clearance_total', 16, 6)->default(0);
            }
            if (! Schema::hasColumn('quotations', 'origin_handling_total')) {
                $table->decimal('origin_handling_total', 16, 6)->default(0);
            }
            if (! Schema::hasColumn('quotations', 'international_freight_total')) {
                $table->decimal('international_freight_total', 16, 6)->default(0);
            }
            if (! Schema::hasColumn('quotations', 'insurance_total')) {
                $table->decimal('insurance_total', 16, 6)->default(0);
            }
            if (! Schema::hasColumn('quotations', 'import_duties_total')) {
                $table->decimal('import_duties_total', 16, 6)->default(0);
            }
            if (! Schema::hasColumn('quotations', 'handling_charges_total')) {
                $table->decimal('handling_charges_total', 16, 6)->default(0);
            }
            if (! Schema::hasColumn('quotations', 'inland_transport_total')) {
                $table->decimal('inland_transport_total', 16, 6)->default(0);
            }
            if (! Schema::hasColumn('quotations', 'cost_factor')) {
                $table->decimal('cost_factor', 16, 6)->default(0);
            }
            if (! Schema::hasColumn('quotations', 'unit_price_with_margin')) {
                $table->decimal('unit_price_with_margin', 16, 6)->default(0);
            }
            if (! Schema::hasColumn('quotations', 'notes')) {
                $table->text('notes')->nullable();
            }
            if (! Schema::hasColumn('quotations', 'expires_at')) {
                $table->timestamp('expires_at')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('quotations', function (Blueprint $table) {
            $table->dropColumn([
                'customer_email',
                'shipping_method',
                'pricing_tier',
                'currency',
                'conversion_rate',
                'margin_percentage',
                'tax_percentage',
                'vat_percentage',
                'subtotal',
                'discount_total',
                'tax_total',
                'grand_total',
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
                'notes',
                'expires_at',
            ]);
        });
    }
};
