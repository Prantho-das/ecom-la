<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use App\Services\SettingService;

class WhyChooseUs extends Component
{

     public $subTitle;
    public $mainTitle;
    public  $backgroundImage = null;
    public  $backgroundImageTwo = null;

    public $statOneTitle;
    public $statOneDesc;
    public $statTwoTitle;
    public $statTwoDesc;

    /**
     * Create a new component instance.
     */
    public function __construct(SettingService $settingService)
    {
       $settings = $settingService->getSettings('choose-us');
        // Assign values with fallbacks
        $this->subTitle       = $settings->get('choose-use_subtitle', 'Why Choose Us');
        $this->mainTitle      = $settings->get('choose-use_title', 'We Are The Best In What We Do');
        $this->backgroundImage = $settings->get('choose-use_image')
            ? \Storage::disk('public')->url($settings->get('choose-use_image'))
            : null;
        $this->backgroundImageTwo = $settings->get('choose-use_image_two')
            ? \Storage::disk('public')->url($settings->get('choose-use_image_two'))
            : null;

        $this->statOneTitle   = $settings->get('choose-use_stat1_title', '10K+');
        $this->statOneDesc    = $settings->get('choose-use_stat1_description', 'Happy Customers');
        $this->statTwoTitle   = $settings->get('choose-use_stat2_title', '300+');
        $this->statTwoDesc    = $settings->get('choose-use_stat2_description', 'Projects Completed');

    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.why-choose-us');
    }
}
