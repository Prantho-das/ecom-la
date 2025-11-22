<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Quotation extends Model
{
    protected $fillable = [
        'customer_name',
        'customer_email',
        'status',
        'subtotal',
        'discount_total',
        'tax_total',
        'grand_total',
        'notes',
        'expires_at',
    ];

    protected $casts = [
        'expires_at' => 'datetime',
    ];

    public function items()
    {
        return $this->hasMany(QuotationItem::class);
    }

    public function calculateTotals()
    {
        $subtotal = $this->items()->sum('row_total');
        $this->subtotal = $subtotal;
        $this->grand_total = $subtotal - $this->discount_total + $this->tax_total;
        $this->save();
    }
}
