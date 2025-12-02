<?php

namespace App\Filament\DarkAdmin\Pages\Settings;

use App\Filament\DarkAdmin\Pages\SiteSettings;
use App\Models\Setting;
use BackedEnum;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\TextInput;
use Filament\Support\Icons\Heroicon;
use UnitEnum;

class ManageFeaturesSettings extends SiteSettings
{
    protected static string|UnitEnum|null $navigationGroup = 'Settings';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static string $settings = 'features';

    protected static ?string $title = 'Features Section Settings';

    protected static ?string $slug = 'features-settings';

    protected function getFormSchema(): array
    {
        return [
            Repeater::make('features_list')
                ->label('Features')
                ->schema([
                    TextInput::make('icon')
                        ->label('Icon (Emoji or Icon Class)')
                        ->required()
                        ->maxLength(255),
                    TextInput::make('title')
                        ->label('Title')
                        ->required()
                        ->maxLength(255),
                    TextInput::make('description')
                        ->label('Description')
                        ->required()
                        ->maxLength(255),
                ])
                ->defaultItems(4)
                ->columns(3)
                ->columnSpanFull(),
        ];
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        $settings = Setting::where('group', static::$settings)->pluck('value', 'key');

        $data['features_list'] = $settings->get('features_list', []);

        return $data;
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        foreach ($data as $key => $value) {
            Setting::updateOrCreate(
                ['group' => static::$settings, 'key' => $key],
                ['value' => $value]
            );
        }

        return []; // Return empty to prevent Filament from trying to save the data in its default way
    }
}
