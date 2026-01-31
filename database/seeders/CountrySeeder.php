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
        $northAmerica = \App\Models\Continent::where('name', 'North America')->first()->id;
        $europe = \App\Models\Continent::where('name', 'Europe')->first()->id;

        \App\Models\Country::insert([
            ['name' => 'United States', 'code' => 'US', 'continent_id' => $northAmerica],
            ['name' => 'Canada', 'code' => 'CA', 'continent_id' => $northAmerica],
            ['name' => 'United Kingdom', 'code' => 'GB', 'continent_id' => $europe],
            ['name' => 'Germany', 'code' => 'DE', 'continent_id' => $europe],
            ['name' => 'France', 'code' => 'FR', 'continent_id' => $europe],
        ]);
    }
}
