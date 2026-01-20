<?php

namespace Database\Seeders;

use App\Models\ShippingConfiguration;
use Illuminate\Database\Seeder;

class ShippingConfigurationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Sea Shipment Configuration (matching Price Sheet.xlsx)
        ShippingConfiguration::create([
            'shipping_method' => 'sea',
            'export_freight_rate' => 0.03,          // 3%
            'export_clearance_rate' => 0.015,       // 1.5%
            'origin_thc_per_cbm' => 15,             // $15 per CBM
            'international_freight_per_cbm' => 20,  // $20 per CBM
            'insurance_rate' => 0.015,              // 1.5%
            'import_duties_fixed' => 2500,          // $2500 fixed
            'import_duties_multiplier' => 1.1,      // 1.1x multiplier
            'handling_charges_fixed' => 200,        // $200 fixed
            'inland_transport_fixed' => 200,        // $200 fixed
            'is_active' => true,
        ]);

        // Air Shipment Configuration (matching Price Sheet.xlsx)
        ShippingConfiguration::create([
            'shipping_method' => 'air',
            'export_freight_rate' => 0.03,          // 3%
            'export_clearance_rate' => 0.015,       // 1.5%
            'airport_handling_per_kg' => 15,        // $15 per KG
            'international_freight_per_kg' => 15,   // $15 per KG
            'insurance_rate' => 0.015,              // 1.5%
            'import_duties_fixed' => 2500,          // $2500 fixed
            'import_duties_multiplier' => 1.1,      // 1.1x multiplier
            'handling_charges_fixed' => 200,        // $200 fixed (not used in air)
            'inland_transport_fixed' => 200,        // $200 fixed (not used in air)
            'is_active' => true,
        ]);
    }
}
