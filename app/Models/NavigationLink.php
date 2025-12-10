<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class NavigationLink extends Model
{
    protected $guarded = [
        'parent_id',
    ];

    public function menu(): BelongsTo
    {
        return $this->belongsTo(NavigationMenu::class, 'navigation_menu_id');
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(NavigationLink::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(NavigationLink::class, 'parent_id')->orderBy('sort_order');
    }

    public function scopeTopLevel(Builder $query): Builder
    {
        return $query->whereNull('parent_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'reference_id');
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class, 'reference_id');
    }

    public function page()
    {
        return $this->belongsTo(Page::class, 'reference_id');
    }

    public function getUrlAttribute()
    {
        switch ($this->type) {
            case 'category':
                return $this->category ? route('category', $this->category->slug) : '#';
            case 'brand':
                return $this->brand ? route('brand.show', $this->brand->slug) : '#';
            case 'page':
                return $this->page ? route('page.show', $this->page->slug) : '#';
            case 'custom':
                return $this->custom_url ?? '#';
            default:
                return $this->custom_url ?? '#';
        }
    }

    public function getLabelAttribute($value)
    {
        // Return custom label or fallback to related model name/title
        if ($value) {
            return $value;
        }
        switch ($this->type) {
            case 'category':
                return $this->category ? $this->category->name : '';
            case 'brand':
                return $this->brand ? $this->brand->name : '';
            case 'page':
                return $this->page ? $this->page->title : '';
            case 'custom':
            default:
                return $value ?? '';
        }
    }
}
