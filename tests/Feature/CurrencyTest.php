<?php

use App\Models\Currency;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('only one currency can be the base', function () {
    $usd = Currency::create([
        'name' => 'US Dollar',
        'code' => 'USD',
        'exchange_rate' => 1.0,
        'is_base' => true,
    ]);

    $bdt = Currency::create([
        'name' => 'Bangladeshi Taka',
        'code' => 'BDT',
        'exchange_rate' => 120.0,
        'is_base' => true,
    ]);

    $usd->refresh();
    $bdt->refresh();

    expect($usd->is_base)->toBeFalse();
    expect($bdt->is_base)->toBeTrue();
    expect(Currency::where('is_base', true)->count())->toBe(1);
});

test('base currency rate is always 1.0', function () {
    $usd = Currency::create([
        'name' => 'US Dollar',
        'code' => 'USD',
        'exchange_rate' => 1.5, // Intentional wrong rate
        'is_base' => true,
    ]);

    expect((float) $usd->exchange_rate)->toBe(1.0);
});

test('currency conversion logic works correctly', function () {
    $usd = Currency::create([
        'name' => 'US Dollar',
        'code' => 'USD',
        'exchange_rate' => 1.0,
        'is_base' => true,
    ]);

    $bdt = Currency::create([
        'name' => 'Bangladeshi Taka',
        'code' => 'BDT',
        'exchange_rate' => 120.0,
        'is_base' => false,
    ]);

    $eur = Currency::create([
        'name' => 'Euro',
        'code' => 'EUR',
        'exchange_rate' => 0.9,
        'is_base' => false,
    ]);

    // Convert 1 USD to BDT
    expect(Currency::convert(1, $usd, $bdt))->toBe(120.0);

    // Convert 120 BDT to USD
    expect(Currency::convert(120, $bdt, $usd))->toBe(1.0);

    // Convert 100 BDT to EUR
    // (100 / 120) * 0.9 = 0.8333... * 0.9 = 0.75
    expect(Currency::convert(100, $bdt, $eur))->toBe(0.75);
});
