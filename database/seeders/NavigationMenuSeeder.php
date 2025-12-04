<?php

namespace Database\Seeders;

use App\Models\NavigationLink;
use App\Models\NavigationMenu;
use Illuminate\Database\Seeder;

class NavigationMenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Find or create the main navigation menu
        $mainMenu = NavigationMenu::firstOrCreate(
            ['slug' => 'main-nav'],
            ['name' => 'Main Nav']
        );

        // Define the navigation links
        $links = [
            [
                'label' => 'Home',
                'type' => 'custom',
                'custom_url' => '/',
                'sort_order' => 1,
            ],
            [
                'label' => 'Products',
                'type' => 'custom',
                'custom_url' => '/products',
                'sort_order' => 2,
            ],
        ];

        // Create the links for the main menu
        foreach ($links as $linkData) {
            NavigationLink::firstOrCreate(
                [
                    'navigation_menu_id' => $mainMenu->id,
                    'label' => $linkData['label'],
                ],
                $linkData
            );
        }
    }
}
