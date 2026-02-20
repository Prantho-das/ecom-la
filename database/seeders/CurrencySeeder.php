<?php

namespace Database\Seeders;

use App\Models\Currency;
use Illuminate\Database\Seeder;

class CurrencySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $currencies = [
            [
                'name' => 'US Dollar',
                'code' => 'USD',
                'symbol' => '$',
                'exchange_rate' => 1.00,
                'is_base' => true,
                'is_active' => true,
            ],
            [
                'name' => 'Euro',
                'code' => 'EUR',
                'symbol' => '€',
                'exchange_rate' => 0.92,
                'is_base' => false,
                'is_active' => true,
            ],
            [
                'name' => 'Chinese Yuan',
                'code' => 'CNY',
                'symbol' => '¥',
                'exchange_rate' => 7.20,
                'is_base' => false,
                'is_active' => true,
            ],
            [
                'name' => 'Bangladeshi Taka',
                'code' => 'BDT',
                'symbol' => '৳',
                'exchange_rate' => 110.00,
                'is_base' => false,
                'is_active' => true,
            ],
        ];

        foreach ($currencies as $currency) {
            Currency::firstOrCreate(
                ['code' => $currency['code']],
                $currency
            );
        }
    }
}
