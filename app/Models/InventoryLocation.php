<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class InventoryLocation extends Model
{
    protected $fillable = [
        'name',
        'code',
        'address',
        'is_primary',
        'manages_stock',
    ];

    protected $casts = [
        'address' => 'array',
        'is_primary' => 'boolean',
        'manages_stock' => 'boolean',
    ];

    public function inventories(): HasMany
    {
        return $this->hasMany(Inventory::class, 'location_id');
    }

    public function stockMovements(): HasMany
    {
        return $this->hasMany(StockMovement::class, 'location_id');
    }
}
