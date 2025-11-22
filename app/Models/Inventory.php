<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    protected $table = 'inventories';

    public $incrementing = false;

    public $timestamps = false;

    protected $primaryKey = null;

    protected $keyType = 'string';

    protected $fillable = [
        'variant_id',
        'location_id',
        'quantity',
        'reserved_quantity',
        'reorder_level',
    ];

    protected $casts = [
        'quantity' => 'integer',
        'reserved_quantity' => 'integer',
        'available' => 'integer',
        'reorder_level' => 'integer',
    ];

    public function variant()
    {
        return $this->belongsTo(ProductVariant::class, 'variant_id');
    }

    public function location()
    {
        return $this->belongsTo(InventoryLocation::class, 'location_id');
    }

    public function movements()
    {
        return $this->hasMany(StockMovement::class, 'variant_id', 'variant_id');
    }
}
