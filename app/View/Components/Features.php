<?php

namespace App\View\Components;

use App\Models\Setting;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Features extends Component
{
    public $featuresList;

    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        $settings = Setting::where('group', 'features')->pluck('value', 'key');

        $this->featuresList = $settings->get('features_list', []);
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.features', [
            'featuresList' => $this->featuresList,
        ]);
    }
}
