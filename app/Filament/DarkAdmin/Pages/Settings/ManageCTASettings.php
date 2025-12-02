<?php

namespace App\Filament\DarkAdmin\Pages\Settings;

use App\Filament\DarkAdmin\Pages\SiteSettings;
use App\Models\Setting;
use BackedEnum;
use Filament\Forms\Components\TextInput;
use Filament\Support\Icons\Heroicon;
use UnitEnum;

class ManageCTASettings extends SiteSettings
{
    protected static string|UnitEnum|null $navigationGroup = 'Settings';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static string $settings = 'cta';

    protected static ?string $title = 'Call to Action Section Settings';

    protected static ?string $slug = 'cta-settings';

    protected function getFormSchema(): array
    {
        return [
            TextInput::make('cta_title')
                ->label('Title')
                ->required()
                ->maxLength(255),
            TextInput::make('cta_description')
                ->label('Description')
                ->required()
                ->columnSpanFull(),
            TextInput::make('cta_button_text')
                ->label('Button Text')
                ->required()
                ->maxLength(255),
            TextInput::make('cta_button_link')
                ->label('Button Link (URL)')
                ->url()
                ->maxLength(255),
        ];
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        $settings = Setting::where('group', static::$settings)->pluck('value', 'key');

        $data['cta_title'] = $settings->get('cta_title');
        $data['cta_description'] = $settings->get('cta_description');
        $data['cta_button_text'] = $settings->get('cta_button_text');
        $data['cta_button_link'] = $settings->get('cta_button_link');

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

        return [];
    }
}
