<?php

namespace Database\Factories;

use App\Models\Quotation;
use App\Models\QuotationItem;
use Illuminate\Database\Eloquent\Factories\Factory;

class QuotationItemFactory extends Factory
{
    protected $model = QuotationItem::class;

    public function definition(): array
    {
        return [
            'quotation_id' => Quotation::factory(),
            'shipment_mode' => 'Sea',
            'incoterm' => 'FOB',
            'product_name' => $this->faker->words(3, true),
            'currency' => 'USD',
            'unit_price' => $this->faker->randomFloat(2, 100, 1000),
            'conversion_rate' => 120.00,
        ];
    }
}
