<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class SolutionCategory extends Model
{
    protected $guarded = ['id'];

    protected $fillable = [
        'title',
        'slug',
        'short_description',
        'published',
        'parent_id',
        'image'
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

    public function parent()
    {
        return $this->belongsTo(SolutionCategory::class, 'parent_id');
    }

}
