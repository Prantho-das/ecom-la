<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CurrencySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Currency::create([
            'name' => 'US Dollar',
            'code' => 'USD',
            'symbol' => '$',
            'exchange_rate' => 1.0,
            'is_base' => true,
        ]);

        \App\Models\Currency::create([
            'name' => 'Bangladeshi Taka',
            'code' => 'BDT',
            'symbol' => '৳',
            'exchange_rate' => 120.0,
            'is_base' => false,
        ]);

        \App\Models\Currency::create([
            'name' => 'Euro',
            'code' => 'EUR',
            'symbol' => '€',
            'exchange_rate' => 0.92,
            'is_base' => false,
        ]);
    }
}
