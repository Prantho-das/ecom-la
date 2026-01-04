<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Solution extends Model
{
    /** @use HasFactory<\Database\Factories\SolutionFactory> */
    use HasFactory;
    protected $fillable = [
        'page_slug',
        'hero_title',
        'hero_subtitle',
        'hero_background_image',
        'features_heading',
        'feature_cards_section',
        'trends_section',
        'cta_section',
        'sections',
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'feature_cards_section' => 'array',
        'trends_section'        => 'array',
        'cta_section'           => 'array',
        'sections'              => 'array',
    ];

    /**
     * Scope to easily get the Vertiv home page content.
     */
    public function scopeHome($query)
    {
        return $query->where('page_slug', 'vertiv-home');
    }

    /**
     * Optional: Accessor to get FAQs easily (since it's the only thing left in sections)
     */
    public function getFaqsAttribute()
    {
        foreach ($this->sections ?? [] as $section) {
            $data = $section['data'] ?? ['items' => []];

            // Ensure we always have the expected structure with title and items
            return [
                'title' => $data['title'] ?? 'FAQs',
                'items' => $data['items'] ?? [],
            ];
        }
        return ['title' => 'FAQs', 'items' => []];
    }

    /**
     * Optional: Accessor for feature cards
     */
    public function getFeatureCardsAttribute()
    {
        return $this->feature_cards_section ?? [];
    }

    /**
     * Optional: Accessor for trends
     */
    public function getTrendsAttribute()
    {
        return $this->trends_section ?? [];
    }

    /**
     * Optional: Accessor for CTA
     */
    public function getCtaAttribute()
    {
        return $this->cta_section ?? [];
    }
    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(SolutionCategory::class);
    }
}
