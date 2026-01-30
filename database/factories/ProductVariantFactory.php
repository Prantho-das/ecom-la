<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductVariantFactory extends Factory
{
    protected $model = ProductVariant::class;

    public function definition(): array
    {
        return [
            'product_id' => Product::factory(),
            'title' => $this->faker->words(2, true),
            'sku' => $this->faker->unique()->bothify('SKU-####-????'),
            'price' => $this->faker->randomFloat(2, 50, 500),
            'weight_kg' => $this->faker->randomFloat(2, 0.5, 20),
            'volume_cbm' => $this->faker->randomFloat(4, 0.01, 1),
        ];
    }
}
