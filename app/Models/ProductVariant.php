<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductVariant extends Model
{
    protected $guarded = [];

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
