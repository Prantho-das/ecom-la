<?php

namespace Database\Seeders;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;

class DummyDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->call(CountrySeeder::class);

        Brand::factory()->count(10)->create();
        Category::factory()->count(15)->create();
        Product::factory()->count(50)->create();
    }
}
