<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $guarded = [
        // 'sku',
    ];

    protected $casts = [
        'published_at' => 'datetime',
        'metafields' => 'array',
        'tags' => 'array',
        'custom_sections' => 'array',
        'pdf_files' => 'array',
    ];

    public function getHasPdfFilesAttribute(): bool
    {
        return ! empty($this->pdf_files);
    }

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

    /** Product belongs to many Countries (Pivot: country_product) */
    public function countries()
    {
        return $this->belongsToMany(Country::class, 'country_product');
    }
}
