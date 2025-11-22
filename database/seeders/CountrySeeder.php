<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Country::insert([
            ['name' => 'United States', 'code' => 'US'],
            ['name' => 'Canada', 'code' => 'CA'],
            ['name' => 'United Kingdom', 'code' => 'GB'],
            ['name' => 'Germany', 'code' => 'DE'],
            ['name' => 'France', 'code' => 'FR'],
        ]);
    }
}
