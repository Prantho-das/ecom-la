<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductVariant extends Model
{
    use HasFactory;
    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'price' => 'decimal:6',
            'compare_at_price' => 'decimal:6',
            'cost_price' => 'decimal:6',
            'weight' => 'decimal:2',
            'weight_kg' => 'decimal:2',
            'volume_cbm' => 'decimal:4',
            'length_cm' => 'decimal:2',
            'width_cm' => 'decimal:2',
            'height_cm' => 'decimal:2',
            'track_inventory' => 'boolean',
            'continue_selling_when_out' => 'boolean',
        ];
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function inventories()
    {
        return $this->hasMany(Inventory::class, 'variant_id');
    }

    public function stockMovements()
    {
        return $this->hasMany(StockMovement::class, 'variant_id');
    }
}
