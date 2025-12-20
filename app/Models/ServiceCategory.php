<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
class ServiceCategory extends Model
{
    protected $guarded = ['id'];

    protected $casts = [
        'links'            => 'array',
        'industries'       => 'array',
        'features'         => 'array',
        'benefits'         => 'array',
        'related_services' => 'array',   // Important: cast to array
        'published'        => 'boolean',
    ];

    public function scopePublished(Builder $query): void
    {
        $query->where('published', true);
    }

    // Optional: relationship for related services
    public function relatedServices()
    {
        return $this->belongsToMany(ServiceCategory::class, null, 'id', 'id')
            ->whereIn('id', $this->related_services ?? []);
    }
}
