<?php

namespace App\View\Components;

use App\Models\NavigationMenu;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Illuminate\View\Component;

class Footer extends Component
{
    public Collection $menus;

    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        $this->menus = NavigationMenu::with('links')
            ->where('handle', 'like', 'footer-%')
            ->get();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View
    {
        return view('components.footer');
    }
}
