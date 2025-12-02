<?php

namespace App\View\Components;

use App\Models\Setting;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Hero extends Component
{
    public $title;

    public $subtitle;

    public $ctaText;

    public $ctaLink;

    public $backgroundImage;

    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        $settings = Setting::where('group', 'hero')->pluck('value', 'key');

        $this->title = $settings->get('hero_title', 'Default Title');
        $this->subtitle = $settings->get('hero_subtitle', 'Default Subtitle');
        $this->ctaText = $settings->get('hero_cta_text', 'Learn More');
        $this->ctaLink = $settings->get('hero_cta_link', '#');
        $this->backgroundImage = $settings->get('hero_background_image');
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.hero', [
            'title' => $this->title,
            'subtitle' => $this->subtitle,
            'ctaText' => $this->ctaText,
            'ctaLink' => $this->ctaLink,
            'backgroundImage' => $this->backgroundImage,
        ]);
    }
}
