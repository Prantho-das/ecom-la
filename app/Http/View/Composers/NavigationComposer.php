<?php

namespace App\Http\View\Composers;

use App\Models\NavigationMenu;
use Illuminate\View\View;

class NavigationComposer
{
    public function compose(View $view)
    {
        $mainMenu = NavigationMenu::where('slug', 'main-nav')->with('links')->first();

        $navLinks = $mainMenu ? $mainMenu->links : collect();

        $view->with('navLinks', $navLinks);
    }
}
