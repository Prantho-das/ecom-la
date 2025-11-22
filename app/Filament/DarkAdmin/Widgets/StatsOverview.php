<?php

namespace App\Filament\DarkAdmin\Widgets;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Country;
use App\Models\InventoryLocation;
use App\Models\Product;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Products', Product::count())
                ->color('success'),
            Stat::make('Total Categories', Category::count())
                ->color('info'),
            Stat::make('Total Brands', Brand::count())
                ->color('warning'),
            Stat::make('Total Users', User::count())
                ->color('primary'),
            Stat::make('Total Inventory Locations', InventoryLocation::count())
                ->color('danger'),
            Stat::make('Total Countries', Country::count())
                ->color('success'),
        ];
    }
}
