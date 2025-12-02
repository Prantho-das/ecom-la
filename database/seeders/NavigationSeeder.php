<?php

namespace Database\Seeders;

use App\Models\NavigationMenu;
use Illuminate\Database\Seeder;

class NavigationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Header Menu
        $headerMenu = NavigationMenu::create([
            'name' => 'Header',
            'handle' => 'header',
            'slug' => 'header',
        ]);

        $headerMenu->links()->createMany([
            ['label' => 'Home', 'type' => 'custom', 'custom_url' => '/', 'sort_order' => 1],
            ['label' => 'Category', 'type' => 'custom', 'custom_url' => '/category', 'sort_order' => 2],
            ['label' => 'Reseller', 'type' => 'custom', 'custom_url' => '/reseller-partner', 'sort_order' => 3],
            ['label' => 'Contact', 'type' => 'custom', 'custom_url' => '/contact', 'sort_order' => 4],
        ]);

        // Footer Menus
        $footerCompany = NavigationMenu::create(['name' => 'Footer Company', 'handle' => 'footer-company', 'slug' => 'footer-company']);
        $footerCompany->links()->createMany([
            ['label' => 'About Us', 'type' => 'custom', 'custom_url' => '#', 'sort_order' => 1],
            ['label' => 'Careers', 'type' => 'custom', 'custom_url' => '#', 'sort_order' => 2],
            ['label' => 'Blog', 'type' => 'custom', 'custom_url' => '#', 'sort_order' => 3],
        ]);

        $footerResources = NavigationMenu::create(['name' => 'Footer Resources', 'handle' => 'footer-resources', 'slug' => 'footer-resources']);
        $footerResources->links()->createMany([
            ['label' => 'Help Center', 'type' => 'custom', 'custom_url' => '#', 'sort_order' => 1],
            ['label' => 'Community', 'type' => 'custom', 'custom_url' => '#', 'sort_order' => 2],
            ['label' => 'Guides', 'type' => 'custom', 'custom_url' => '#', 'sort_order' => 3],
        ]);

        $footerProducts = NavigationMenu::create(['name' => 'Footer Products', 'handle' => 'footer-products', 'slug' => 'footer-products']);
        $footerProducts->links()->createMany([
            ['label' => 'Pricing', 'type' => 'custom', 'custom_url' => '#', 'sort_order' => 1],
            ['label' => 'Features', 'type' => 'custom', 'custom_url' => '#', 'sort_order' => 2],
            ['label' => 'Integrations', 'type' => 'custom', 'custom_url' => '#', 'sort_order' => 3],
        ]);

        $footerLegal = NavigationMenu::create(['name' => 'Footer Legal', 'handle' => 'footer-legal', 'slug' => 'footer-legal']);
        $footerLegal->links()->createMany([
            ['label' => 'Privacy Policy', 'type' => 'custom', 'custom_url' => '#', 'sort_order' => 1],
            ['label' => 'Terms of Service', 'type' => 'custom', 'custom_url' => '#', 'sort_order' => 2],
        ]);
    }
}
