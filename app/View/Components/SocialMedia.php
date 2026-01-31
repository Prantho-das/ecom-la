<?php

namespace App\View\Components;

use App\Services\SettingService;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class SocialMedia extends Component
{
    public $socialMediaLinks;

    /**
     * Create a new component instance.
     */
    public function __construct(SettingService $settingService)
    {
        $settings = $settingService->getSettings('social_media');

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
