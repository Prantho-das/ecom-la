<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Country extends Model
{
    protected $fillable = ['name', 'code', 'continent_id'];

    public function continent(): BelongsTo
    {
        return $this->belongsTo(Continent::class);
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'country_product');
    }
}
