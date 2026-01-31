<?php

require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();


use App\Models\Quotation;
use App\Models\QuotationItem;
use App\Services\QuotationCalculationService;
use Illuminate\Support\Str;

echo "Starting Quotation System Verification...\n";

// 1. Math Verification via Service
$service = new QuotationCalculationService();
$base = 10000;
$conf = [
    'export_freight_rate' => 3,
    'export_clearance_rate' => 2,
    'origin_thc_rate' => 15,
    'origin_thc_qty' => 5, // CUSTOM QTY
    'int_freight_cbm' => 20,
    'int_freight_kg' => 100, // CUSTOM KG
    'insurance_rate' => 2,
    'import_duties_fixed' => 2500,
    'import_duties_multiplier' => 1.1,
    'handling_charges_global' => 200,
    'inland_transport_global' => 200,
];
$conversionRate = 125;
$margin = 30;
$tax = 5;
$vat = 10;

$results = $service->calculateMatrix($base, $conf, $conversionRate, $margin, $tax, $vat);

// Verify THC calculation: 15 * 5 = 75
if ($results['DDP']['costs']['oh'] == 75) {
    echo "✓ THC Math Correct: 15 * 5 = 75\n";
} else {
    echo "✗ THC Math Failed: " . $results['DDP']['costs']['oh'] . "\n";
}

// Verify Freight calculation: 20 * 100 = 2000
if ($results['DDP']['costs']['inf'] == 2000) {
    echo "✓ Freight Math Correct: 20 * 100 = 2000\n";
} else {
    echo "✗ Freight Math Failed: " . $results['DDP']['costs']['inf'] . "\n";
}

// Verify BDT Local calculation: 10000 * 125 = 1,250,000
if ($results['BDT (Local)']['up'] == 1250000) {
    echo "✓ BDT Local Math Correct: 10000 * 125 = 1,250,000\n";
} else {
    echo "✗ BDT Local Math Failed: " . $results['BDT (Local)']['up'] . "\n";
}

// 2. Persistence Verification
$quotation = Quotation::create([
    'customer_name' => 'Verify Test',
    'customer_email' => 'test@verify.com',
    'quotation_date' => now(),
    'currency' => 'USD',
    'status' => 'draft',
]);

$item = $quotation->items()->create([
    'product_name' => 'Test Item',
    'quantity' => 1,
    'unit_price' => 10000,
    'origin_thc_qty' => 5,
    'int_freight_rate_2' => 100,
    'export_freight_rate' => 3.5,
]);

$reloadedItem = QuotationItem::find($item->id);

if ($reloadedItem->origin_thc_qty == 5) {
    echo "✓ Persistence Correct: origin_thc_qty preserved as 5\n";
} else {
    echo "✗ Persistence Failed: origin_thc_qty is " . $reloadedItem->origin_thc_qty . "\n";
}

if ($reloadedItem->export_freight_rate == 3.5) {
    echo "✓ Persistence Correct: export_freight_rate preserved as 3.5\n";
} else {
    echo "✗ Persistence Failed: export_freight_rate is " . $reloadedItem->export_freight_rate . "\n";
}

// Clean up
$quotation->delete();

echo "Verification Complete.\n";
