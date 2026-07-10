<?php

use App\Models\Quotation;
use App\Models\QuotationItem;
use App\Services\QuotationCalculationService;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->seed(\Database\Seeders\ShippingConfigurationSeeder::class);
});

test('it calculates exwork correctly', function () {
    $service = new QuotationCalculationService;
    $basePrice = 100;

    $quotation = Quotation::factory()->create([
        'shipping_method' => 'sea',
        'pricing_tier' => 'exwork',
        'margin_percentage' => 0,
        'tax_percentage' => 0,
        'vat_percentage' => 0,
    ]);

    $item = QuotationItem::create([
        'quotation_id' => $quotation->id,
        'product_name' => 'Test Product',
        'unit_price' => $basePrice,
        'shipment_mode' => 'Sea',
        'incoterm' => 'Exwork',
        'currency' => 'USD',
    ]);

    $service->recalculateAllItems($quotation);
    $item->refresh();

    // Exwork = Base Price only
    expect($item->final_unit_price)->toEqual($basePrice)
        ->and($item->export_freight_local)->toEqual(0);
});

test('it calculates fob sea correctly', function () {
    $service = new QuotationCalculationService;
    $basePrice = 1000;

    $quotation = Quotation::factory()->create([
        'shipping_method' => 'sea',
        'pricing_tier' => 'fob',
        'margin_percentage' => 0,
        'tax_percentage' => 0,
        'vat_percentage' => 0,
    ]);

    $item = createTestItem($quotation, $basePrice);
    $service->recalculateAllItems($quotation);
    $item->refresh();

    $expectedExportFreight = $basePrice * 0.03; // 30
    $expectedExportClearance = $basePrice * 0.015; // 15
    $expectedOriginHandling = 0; // Volume based handling is 0 as volume columns were removed

    $expectedTotal = $basePrice + $expectedExportFreight + $expectedExportClearance + $expectedOriginHandling;

    expect($item->export_freight_local)->toEqual($expectedExportFreight)
        ->and($item->export_clearance)->toEqual($expectedExportClearance)
        ->and($item->origin_thc)->toEqual($expectedOriginHandling)
        ->and($item->final_unit_price)->toEqual($expectedTotal);
});

test('it calculates cif sea correctly', function () {
    $service = new QuotationCalculationService;
    $basePrice = 1000;

    $quotation = Quotation::factory()->create([
        'shipping_method' => 'sea',
        'pricing_tier' => 'cif',
        'margin_percentage' => 0,
        'tax_percentage' => 0,
        'vat_percentage' => 0,
    ]);

    $item = createTestItem($quotation, $basePrice);
    $service->recalculateAllItems($quotation);
    $item->refresh();

    // FOB costs: 1000 + 30 + 15 + 0 = 1045
    // CIF adds:
    // International Freight = 0 (as volume/weight columns were removed)
    // Insurance = $1000 * 1.5% = $15 (assuming 1.5% from service logic)

    // Actually, following service logic in calculateMatrix:
    // c_ins = $base * ($conf['insurance_rate'] / 100)
    // In model calculateCIF calls calculateCFR which calls calculateFOB

    $expectedTotal = 1000 + 30 + 15 + 0 + 0 + 15; // Base + EF + EC + OH + IF + INS = 1060

    expect($item->insurance)->toEqual(15)
        ->and($item->final_unit_price)->toEqual(1060);
});

test('it calculates margins and taxes correctly', function () {
    $service = new QuotationCalculationService;
    $basePrice = 100;

    $quotation = Quotation::factory()->create([
        'shipping_method' => 'sea',
        'pricing_tier' => 'exwork',
        'margin_percentage' => 30,
        'tax_percentage' => 0.05, // 5% stored as decimal
        'vat_percentage' => 0.10, // 10% stored as decimal
    ]);

    $item = createTestItem($quotation, $basePrice);
    $service->recalculateAllItems($quotation);
    $item->refresh();

    // Base Cost = 100
    // With Margin (30%) = 100 * 1.3 = 130
    // With Tax (5%) + VAT (10%) = 130 * (1 + 0.05 + 0.10) = 130 * 1.15 = 149.5 -> 150 (rounded)

    expect($item->unit_price_with_mg)->toEqual(130)
        ->and($item->final_unit_price)->toEqual(150);
});

// Helper function
function createTestItem($quotation, $price)
{
    return QuotationItem::create([
        'quotation_id' => $quotation->id,
        'product_name' => 'Test Product',
        'unit_price' => $price,
        'shipment_mode' => 'Sea',
        'incoterm' => $quotation->pricing_tier,
        'currency' => 'USD',
        'margin_percentage' => $quotation->margin_percentage,
        'tax_percent' => $quotation->tax_percentage,
        'vat_percent' => $quotation->vat_percentage,
    ]);
}

test('it calculates custom cost factor correctly when enabled', function () {
    $service = new QuotationCalculationService;
    $basePrice = 1000;

    // Create an incoterm that has custom cost factor enabled
    \App\Models\Incoterm::create([
        'name' => 'Custom Incoterm',
        'code' => 'CUSTOM-INC',
        'is_active' => true,
        'has_export_freight' => false,
        'has_export_clearance' => false,
        'has_origin_thc' => false,
        'has_int_freight' => false,
        'has_insurance' => false,
        'has_import_duties' => false,
        'has_handling_charges' => false,
        'has_inland_transport' => false,
        'has_custom_cost_factor' => true,
    ]);

    $quotation = Quotation::factory()->create([
        'shipping_method' => 'sea',
        'pricing_tier' => 'CUSTOM-INC',
        'margin_percentage' => 0,
        'tax_percentage' => 0,
        'vat_percentage' => 0,
    ]);

    $item = QuotationItem::create([
        'quotation_id' => $quotation->id,
        'product_name' => 'Test Product',
        'unit_price' => $basePrice,
        'shipment_mode' => 'Sea',
        'incoterm' => 'CUSTOM-INC',
        'currency' => 'USD',
        'custom_cost_factor_rate' => 150.00,
    ]);

    $service->recalculateAllItems($quotation);
    $item->refresh();

    expect($item->custom_cost_factor)->toEqual(150.00)
        ->and($item->cost_factor)->toEqual(150.00)
        ->and($item->final_unit_price)->toEqual($basePrice + 150.00);
});
