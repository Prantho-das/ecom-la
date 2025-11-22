<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuotationItem extends Model
{
    protected $fillable = [
        'quotation_id',
        'variant_id',
        'name',
        'sku',
        'quantity',
        'price',
        'row_total',
    ];

    public function quotation()
    {
        return $this->belongsTo(Quotation::class);
    }

    public function variant()
    {
        return $this->belongsTo(ProductVariant::class, 'variant_id');
    }
}
