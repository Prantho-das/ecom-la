<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class SolutionCategory extends Model
{
    protected $guarded = ['id'];

    protected $casts = [
        'links'            => 'array',
        'industries'       => 'array',
        'features'         => 'array',
        'benefits'         => 'array',
        'related_services' => 'array',
        'published'        => 'boolean',
    ];

    public function scopePublished(Builder $query): void
    {
        $query->where('published', true);
    }

    public function relatedServices(): BelongsToMany
    {
        return $this->belongsToMany(SolutionCategory::class, null, 'id', 'id')
            ->whereIn('id', $this->related_services ?? []);
    }

    public function solutions(): BelongsToMany
    {
        return $this->belongsToMany(Solution::class);
    }
}