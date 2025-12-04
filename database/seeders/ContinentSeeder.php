<?php

namespace Database\Seeders;

use App\Models\Continent;
use Illuminate\Database\Seeder;

class ContinentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $continents = [
            ['name' => 'Asia'],
            ['name' => 'Africa'],
            ['name' => 'North America'],
            ['name' => 'South America'],
            ['name' => 'Antarctica'],
            ['name' => 'Europe'],
            ['name' => 'Australia'],
        ];

        foreach ($continents as $continent) {
            Continent::create($continent);
        }
    }
}
