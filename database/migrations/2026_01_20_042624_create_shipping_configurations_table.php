<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('shipping_configurations', function (Blueprint $table) {
            $table->id();
            $table->enum('shipping_method', ['sea', 'air'])->default('sea');

            // Cost factors (percentage or fixed rates)
            $table->decimal('export_freight_rate', 8, 4)->default(0.03)->comment('3% of product price');
            $table->decimal('export_clearance_rate', 8, 4)->default(0.015)->comment('1.5% of product price');
            $table->decimal('origin_thc_per_cbm', 10, 2)->default(15)->comment('For sea shipment - per CBM');
            $table->decimal('airport_handling_per_kg', 10, 2)->default(15)->comment('For air shipment - per KG');
            $table->decimal('international_freight_per_cbm', 10, 2)->default(20)->comment('Sea freight per CBM');
            $table->decimal('international_freight_per_kg', 10, 2)->default(15)->comment('Air freight per KG');
            $table->decimal('insurance_rate', 8, 4)->default(0.015)->comment('1.5% of product price');
            $table->decimal('import_duties_fixed', 10, 2)->default(2500)->comment('Fixed import duty amount');
            $table->decimal('import_duties_multiplier', 8, 4)->default(1.1)->comment('Import duty multiplier');
            $table->decimal('handling_charges_fixed', 10, 2)->default(200)->comment('Fixed handling charges');
            $table->decimal('inland_transport_fixed', 10, 2)->default(200)->comment('Fixed inland transport cost');

            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index(['shipping_method', 'is_active']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('shipping_configurations');
    }
};
