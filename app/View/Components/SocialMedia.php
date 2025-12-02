<?php

namespace App\View\Components;

use App\Models\Setting;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class SocialMedia extends Component
{
    public $socialMediaLinks;

    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        $settings = Setting::where('group', 'social_media')->pluck('value', 'key');

        $this->socialMediaLinks = $settings->get('social_media_links', []);
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.social-media', [
            'socialMediaLinks' => $this->socialMediaLinks,
        ]);
    }
}
