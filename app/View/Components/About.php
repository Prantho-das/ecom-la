<?php

namespace App\View\Components;

use App\Services\SettingService;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class About extends Component
{
    public $subtitle;

    public $title;

    public $description;

    public $listItems;

    public $buttonText;

    public $buttonLink;

    public $image;

    public $stat1Title;

    public $stat1Value;

    public $stat1Description;

    public $stat2Title;

    public $stat2Value;

    public $stat2Description;

    /**
     * Create a new component instance.
     */
    public function __construct(SettingService $settingService)
    {
        $settings = $settingService->getSettings('about');

        $this->subtitle = $settings->get('about_subtitle', 'Default Subtitle');
        $this->title = $settings->get('about_title', 'Default Title');
        $this->description = $settings->get('about_description', 'Default Description');
        $this->listItems = $settings->get('about_list_items', []);
        $this->buttonText = $settings->get('about_button_text', 'About Us');
        $this->buttonLink = $settings->get('about_button_link', '#');
        $this->image = $settings->get('about_image');
        $this->stat1Title = $settings->get('about_stat1_title', 'Experts');
        $this->stat1Value = $settings->get('about_stat1_value', '90+');
        $this->stat1Description = $settings->get('about_stat1_description', 'Adipiscing elit, do eiusm.');
        $this->stat2Title = $settings->get('about_stat2_title', 'Stations');
        $this->stat2Value = $settings->get('about_stat2_value', '16');
        $this->stat2Description = $settings->get('about_stat2_description', 'Sed do eius mod tempor.');
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.about', [
            'subtitle' => $this->subtitle,
            'title' => $this->title,
            'description' => $this->description,
            'listItems' => $this->listItems,
            'buttonText' => $this->buttonText,
            'buttonLink' => $this->buttonLink,
            'image' => $this->image,
            'stat1Title' => $this->stat1Title,
            'stat1Value' => $this->stat1Value,
            'stat1Description' => $this->stat1Description,
            'stat2Title' => $this->stat2Title,
            'stat2Value' => $this->stat2Value,
            'stat2Description' => $this->stat2Description,
        ]);
    }
}
