<?php

namespace App\Filament\DarkAdmin\Pages\Settings;

use App\Filament\DarkAdmin\Pages\SiteSettings;
use App\Models\Setting;
use BackedEnum;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Support\Icons\Heroicon;
use UnitEnum;

class ManageHeroSettings extends SiteSettings
{
    protected static string|UnitEnum|null $navigationGroup = 'Settings';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static string $settings = 'hero';

    protected static ?string $title = 'Hero Section Settings';

    protected static ?string $slug = 'hero-settings';

    protected function getFormSchema(): array
    {
        return [
            TextInput::make('hero_title')
                ->label('Title')
                ->required()
                ->maxLength(255),
            TextInput::make('hero_subtitle')
                ->label('Subtitle')
                ->maxLength(255),
            TextInput::make('hero_cta_text')
                ->label('Call to Action Text')
                ->maxLength(255),
            TextInput::make('hero_cta_link')
                ->label('Call to Action Link (URL)')
                ->url()
                ->maxLength(255),
            FileUpload::make('hero_background_image')
                ->label('Background Image')
                ->directory('hero')
                ->image()
                ->nullable(),
        ];
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        $settings = Setting::where('group', static::$settings)->pluck('value', 'key');

        $data['hero_title'] = $settings->get('hero_title');
        $data['hero_subtitle'] = $settings->get('hero_subtitle');
        $data['hero_cta_text'] = $settings->get('hero_cta_text');
        $data['hero_cta_link'] = $settings->get('hero_cta_link');
        $data['hero_background_image'] = $settings->get('hero_background_image');

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
