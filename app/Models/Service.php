<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Service extends Model
{
    protected $guarded=[];
    protected $casts = [
        'links'            => 'array',
        'industries'       => 'array',
        'features'         => 'array',
        'benefits'         => 'array',
        'related_services' => 'array',   // Important: cast to array
        'published'        => 'boolean',
    ];
    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(ServiceCategory::class,);
    }

    public function scopePublished($query)
    {
        return $query->where('published', 1); // or where('status', 'published'), etc.
    }
}
