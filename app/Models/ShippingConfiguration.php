<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShippingConfiguration extends Model
{
    protected $fillable = [
        'shipping_method',
        'export_freight_rate',
        'export_clearance_rate',
        'origin_thc_per_cbm',
        'airport_handling_per_kg',
        'international_freight_per_cbm',
        'international_freight_per_kg',
        'insurance_rate',
        'import_duties_fixed',
        'import_duties_multiplier',
        'handling_charges_fixed',
        'inland_transport_fixed',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'export_freight_rate' => 'decimal:4',
            'export_clearance_rate' => 'decimal:4',
            'origin_thc_per_cbm' => 'decimal:2',
            'airport_handling_per_kg' => 'decimal:2',
            'international_freight_per_cbm' => 'decimal:2',
            'international_freight_per_kg' => 'decimal:2',
            'insurance_rate' => 'decimal:4',
            'import_duties_fixed' => 'decimal:2',
            'import_duties_multiplier' => 'decimal:4',
            'handling_charges_fixed' => 'decimal:2',
            'inland_transport_fixed' => 'decimal:2',
        ];
    }

    /**
     * Get active shipping configuration for a specific method
     */
    public static function getActiveConfig(string $method = 'sea'): ?self
    {
        return self::where('shipping_method', $method)
            ->where('is_active', true)
            ->first();
    }

    /**
     * Get the default configuration
     */
    public static function getDefault(): ?self
    {
        return self::where('is_active', true)->first();
    }
}
