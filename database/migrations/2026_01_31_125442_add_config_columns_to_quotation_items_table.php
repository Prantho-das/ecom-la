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
            $table->decimal('export_freight_rate', 10, 4)->default(0)->after('unit_price');
            $table->decimal('export_clearance_rate', 10, 4)->default(0)->after('export_freight_rate');
            $table->decimal('origin_thc_rate', 15, 2)->default(0)->after('export_clearance_rate');
            $table->decimal('origin_thc_qty', 10, 2)->default(1)->after('origin_thc_rate');
            $table->decimal('int_freight_rate_1', 15, 2)->default(0)->after('origin_thc_qty');
            $table->decimal('int_freight_rate_2', 10, 2)->default(1)->after('int_freight_rate_1');
            $table->decimal('insurance_rate', 10, 4)->default(0)->after('int_freight_rate_2');
            $table->decimal('import_duties_fixed', 15, 2)->default(0)->after('insurance_rate');
            $table->decimal('import_duties_multiplier', 10, 4)->default(1)->after('import_duties_fixed');
            $table->decimal('handling_charges_global', 15, 2)->default(0)->after('import_duties_multiplier');
            $table->decimal('inland_transport_global', 15, 2)->default(0)->after('handling_charges_global');
        });
    }

    public function down(): void
    {
        Schema::table('quotation_items', function (Blueprint $table) {
            $table->dropColumn([
                'export_freight_rate',
                'export_clearance_rate',
                'origin_thc_rate',
                'origin_thc_qty',
                'int_freight_rate_1',
                'int_freight_rate_2',
                'insurance_rate',
                'import_duties_fixed',
                'import_duties_multiplier',
                'handling_charges_global',
                'inland_transport_global',
            ]);
        });
    }
};
