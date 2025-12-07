<?php

namespace App\View\Components;

use App\Services\SettingService;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Cta extends Component
{
    public $title;

    public $description;

    public $buttonText;

    public $buttonLink;

    /**
     * Create a new component instance.
     */
    public function __construct(SettingService $settingService)
    {
        $settings = $settingService->getSettings('cta');

        $this->title = $settings->get('cta_title', 'Default CTA Title');
        $this->description = $settings->get('cta_description', 'Default CTA Description');
        $this->buttonText = $settings->get('cta_button_text', 'Get in Touch');
        $this->buttonLink = $settings->get('cta_button_link', '#');
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.cta', [
            'title' => $this->title,
            'description' => $this->description,
            'buttonText' => $this->buttonText,
            'buttonLink' => $this->buttonLink,
        ]);
    }
}
