<?php

use App\Models\ProductVariant;
use App\Models\Quotation;
use App\Models\QuotationItem;
use App\Models\ShippingConfiguration;
use App\Services\QuotationCalculationService;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
  $this->seed(\Database\Seeders\ShippingConfigurationSeeder::class);
});

test('it calculates exwork correctly', function () {
  $service = new QuotationCalculationService();
  $basePrice = 100;

  $quotation = Quotation::factory()->create([
    'shipping_method' => 'sea',
    'pricing_tier' => 'exwork',
    'margin_percentage' => 0,
    'tax_percentage' => 0,
    'vat_percentage' => 0,
  ]);

  $variant = ProductVariant::factory()->create([
    'price' => $basePrice,
    'weight_kg' => 10,
    'volume_cbm' => 0.5,
  ]);

  $item = QuotationItem::create([
    'quotation_id' => $quotation->id,
    'variant_id' => $variant->id,
    'name' => 'Test Product',
    'quantity' => 1,
    'unit_product_price' => $basePrice,
    'weight_kg' => 10,
    'volume_cbm' => 0.5,
  ]);

  $service->recalculateAllItems($quotation);
  $item->refresh();

  // Exwork = Base Price only
  expect($item->final_unit_price)->toEqual($basePrice)
    ->and($item->export_freight)->toEqual(0);
});

test('it calculates fob sea correctly', function () {
  $service = new QuotationCalculationService();
  $basePrice = 1000;
  $volume = 2; // CBM

  $quotation = Quotation::factory()->create([
    'shipping_method' => 'sea',
    'pricing_tier' => 'fob',
    'margin_percentage' => 0,
    'tax_percentage' => 0,
    'vat_percentage' => 0,
  ]);

  $item = createTestItem($quotation, $basePrice, 10, $volume);
  $service->recalculateAllItems($quotation);
  $item->refresh();

  $config = ShippingConfiguration::getActiveConfig('sea');

  $expectedExportFreight = $basePrice * 0.03; // 30
  $expectedExportClearance = $basePrice * 0.015; // 15
  $expectedOriginHandling = $volume * 15; // 30

  $expectedTotal = $basePrice + $expectedExportFreight + $expectedExportClearance + $expectedOriginHandling;

  expect($item->export_freight)->toEqual($expectedExportFreight)
    ->and($item->export_clearance)->toEqual($expectedExportClearance)
    ->and($item->origin_handling)->toEqual($expectedOriginHandling)
    ->and($item->final_unit_price)->toEqual($expectedTotal);
});

test('it calculates cif sea correctly', function () {
  $service = new QuotationCalculationService();
  $basePrice = 1000;
  $volume = 2; // CBM

  $quotation = Quotation::factory()->create([
    'shipping_method' => 'sea',
    'pricing_tier' => 'cif',
    'margin_percentage' => 0,
    'tax_percentage' => 0,
    'vat_percentage' => 0,
  ]);

  $item = createTestItem($quotation, $basePrice, 10, $volume);
  $service->recalculateAllItems($quotation);
  $item->refresh();

  // Previous costs (FOB)
  $fobCost = 1000 + 30 + 15 + 30; // 1075

  // CIF adds:
  // International Freight = 2 CBM * $20 = $40
  // Insurance = $1000 * 1.5% = $15

  $expectedTotal = $fobCost + 40 + 15; // 1130

  expect($item->international_freight)->toEqual(40)
    ->and($item->insurance)->toEqual(15)
    ->and($item->final_unit_price)->toEqual($expectedTotal);
});

test('it calculates margins and taxes correctly', function () {
  $service = new QuotationCalculationService();
  $basePrice = 100;

  $quotation = Quotation::factory()->create([
    'shipping_method' => 'sea',
    'pricing_tier' => 'exwork', // Keep it simple
    'margin_percentage' => 30,
    'tax_percentage' => 5, // 5%
    'vat_percentage' => 10, // 10%
  ]);

  $item = createTestItem($quotation, $basePrice, 1, 0.1);
  $service->recalculateAllItems($quotation);
  $item->refresh();

  // Base Cost = 100
  // With Margin (30%) = 100 * 1.3 = 130
  // With Tax (5%) + VAT (10%) = 130 * (1 + 0.05 + 0.10) = 130 * 1.15 = 149.5 -> 150 (rounded)

  expect($item->unit_price_with_margin)->toEqual(130)
    ->and($item->final_unit_price)->toEqual(150);
});

// Helper function
function createTestItem($quotation, $price, $weight, $volume)
{
  $variant = ProductVariant::factory()->create([
    'price' => $price,
    'weight_kg' => $weight,
    'volume_cbm' => $volume,
  ]);

  return QuotationItem::create([
    'quotation_id' => $quotation->id,
    'variant_id' => $variant->id,
    'name' => 'Test Product',
    'quantity' => 1,
    'unit_product_price' => $price,
    'weight_kg' => $weight,
    'volume_cbm' => $volume,
  ]);
}
