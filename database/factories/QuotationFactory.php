<?php

namespace Database\Factories;

use App\Models\Quotation;
use Illuminate\Database\Eloquent\Factories\Factory;

class QuotationFactory extends Factory
{
    protected $model = Quotation::class;

    public function definition(): array
    {
        return [
            'reference_number' => 'QT-' . $this->faker->unique()->numberBetween(1000, 9999),
            'customer_name' => $this->faker->name(),
            'customer_email' => $this->faker->safeEmail(),
            'quotation_date' => now(),
            'status' => 'draft',
            'shipping_method' => 'sea',
            'pricing_tier' => 'fob',
            'currency' => 'USD',
            'conversion_rate' => 120.00,
            'margin_percentage' => 15.00,
            'tax_percentage' => 0,
            'vat_percentage' => 0,
        ];
    }
}
