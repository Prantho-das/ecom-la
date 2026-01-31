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

        $getValue = function ($key, $default) use ($settings) {
            $value = $settings->get($key, $default);
            return is_array($value) ? ($value[0] ?? $default) : $value;
        };

        $this->title = $getValue('cta_title', 'Ready to take your business to the next level?');
        $this->description = $getValue('cta_description', 'Contact us today to schedule a consultation and see how we can help you achieve your goals.');
        $this->buttonText = $getValue('cta_button_text', 'Contact Us');
        $this->buttonLink = $getValue('cta_button_link', '/contact');
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
