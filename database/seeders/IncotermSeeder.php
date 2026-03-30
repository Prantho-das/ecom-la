<?php

namespace Database\Seeders;

use App\Models\Incoterm;
use Illuminate\Database\Seeder;

class IncotermSeeder extends Seeder
{
    public function run(): void
    {
        $incoterms = [
            [
                'name' => 'Ex Works',
                'code' => 'Exwork',
                'is_active' => true,
                'has_export_freight' => false,
                'has_export_clearance' => false,
                'has_origin_thc' => false,
                'has_int_freight' => false,
                'has_insurance' => false,
                'has_import_duties' => false,
                'has_handling_charges' => false,
                'has_inland_transport' => false,
                'currency_defaults' => [],
            ],
            [
                'name' => 'Free On Board',
                'code' => 'FOB',
                'is_active' => true,
                'has_export_freight' => true,
                'has_export_clearance' => true,
                'has_origin_thc' => true,
                'has_int_freight' => false,
                'has_insurance' => false,
                'has_import_duties' => false,
                'has_handling_charges' => false,
                'has_inland_transport' => false,
                'currency_defaults' => [],
            ],
            [
                'name' => 'Cost and Freight',
                'code' => 'CFR',
                'is_active' => true,
                'has_export_freight' => true,
                'has_export_clearance' => true,
                'has_origin_thc' => true,
                'has_int_freight' => true,
                'has_insurance' => false,
                'has_import_duties' => false,
                'has_handling_charges' => false,
                'has_inland_transport' => false,
                'currency_defaults' => [],
            ],
            [
                'name' => 'Cost Insurance and Freight',
                'code' => 'CIF',
                'is_active' => true,
                'has_export_freight' => true,
                'has_export_clearance' => true,
                'has_origin_thc' => true,
                'has_int_freight' => true,
                'has_insurance' => true,
                'has_import_duties' => false,
                'has_handling_charges' => false,
                'has_inland_transport' => false,
                'currency_defaults' => [],
            ],
            [
                'name' => 'Delivered Duty Unpaid / Delivered At Place',
                'code' => 'DDU/DAP',
                'is_active' => true,
                'has_export_freight' => true,
                'has_export_clearance' => true,
                'has_origin_thc' => true,
                'has_int_freight' => true,
                'has_insurance' => true,
                'has_import_duties' => false,
                'has_handling_charges' => true,
                'has_inland_transport' => true,
                'currency_defaults' => [],
            ],
            [
                'name' => 'Delivered Duty Paid',
                'code' => 'DDP',
                'is_active' => true,
                'has_export_freight' => true,
                'has_export_clearance' => true,
                'has_origin_thc' => true,
                'has_int_freight' => true,
                'has_insurance' => true,
                'has_import_duties' => true,
                'has_handling_charges' => true,
                'has_inland_transport' => true,
                'currency_defaults' => [],
            ],
        ];

        foreach ($incoterms as $data) {
            Incoterm::firstOrCreate(
                ['code' => $data['code']],
                $data
            );
        }
    }
}
