<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $guarded = [];

    protected $casts = [
        'published_at' => 'datetime',
        'metafields' => 'array',
        'tags' => 'array',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    /** Product belongs to a Brand */
    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    /** Product belongs to many Categories (Pivot: category_product) */
    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_product')
            ->withPivot('position');
    }

    /** Product has many Options (e.g. Color, Size) */
    public function options()
    {
        return $this->hasMany(Option::class);
    }

    /** Product has many Variants */
    public function variants()
    {
        return $this->hasMany(ProductVariant::class);
    }

    /** Product has many Images */
    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }

    /** Get all option values through options */
    public function optionValues()
    {
        return $this->hasManyThrough(OptionValue::class, Option::class);
    }

    /** Get all variant option values (all combinations used by variants) */
    public function variantOptionValues()
    {
        return $this->hasManyThrough(
            OptionValue::class,
            ProductVariant::class,
            'product_id',
            'id'
        );
    }
}
