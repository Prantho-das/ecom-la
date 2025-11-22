<?php

namespace App\Filament\DarkAdmin\Resources\NavigationLinks\Schemas;

use Filament\Schemas\Schema;

class NavigationLinkForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                \Filament\Forms\Components\Select::make('navigation_menu_id')
                ->relationship('menu', 'name')
                ->required(),
    
            \Filament\Forms\Components\Select::make('type')
                ->options([
                    'category' => 'Category',
                    'brand' => 'Brand',
                    'page' => 'Page',
                    'custom' => 'Custom URL',
                ])
                ->reactive()
                ->required(),
    
            \Filament\Forms\Components\Select::make('reference_id')
                ->label('Reference')
                ->options(function (callable $get) {
                    $type = $get('type');
    
                    return match ($type) {
                        'category' => \App\Models\Category::pluck('name', 'id'),
                        'brand' => \App\Models\Brand::pluck('name', 'id'),
                        'page' => \App\Models\Page::pluck('title', 'id'),
                        default => [],
                    };
                })
                ->visible(fn ($get) => in_array($get('type'), ['category', 'brand', 'page']))
                ->required(fn ($get) => in_array($get('type'), ['category', 'brand', 'page'])),
    
            \Filament\Forms\Components\TextInput::make('custom_url')
                ->label('Custom URL')
                ->url()
                ->visible(fn ($get) => $get('type') === 'custom')
                ->required(fn ($get) => $get('type') === 'custom'),
    
            \Filament\Forms\Components\TextInput::make('label')
                ->helperText('Optional custom label (overrides default)'),
    
            \Filament\Forms\Components\TextInput::make('sort_order')
                ->default(0)
                ->numeric()
                ->required(),
            ]);
    }
}
