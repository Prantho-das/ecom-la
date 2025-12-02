<?php

namespace App\Filament\DarkAdmin\Pages\Settings;

use App\Filament\DarkAdmin\Pages\SiteSettings;
use App\Models\Setting;
use BackedEnum;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TextInput;
use Filament\Support\Icons\Heroicon;
use UnitEnum;

class ManageAboutSettings extends SiteSettings
{
    protected static string|UnitEnum|null $navigationGroup = 'Settings';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static string $settings = 'about';

    protected static ?string $title = 'About Section Settings';

    protected static ?string $slug = 'about-settings';

    protected function getFormSchema(): array
    {
        return [
            TextInput::make('about_subtitle')
                ->label('Subtitle')
                ->required()
                ->maxLength(255),
            TextInput::make('about_title')
                ->label('Title')
                ->required()
                ->maxLength(255),
            RichEditor::make('about_description')
                ->label('Description')
                ->required()
                ->columnSpanFull(),
            Repeater::make('about_list_items')
                ->label('List Items')
                ->schema([
                    TextInput::make('item')
                        ->label('Item Text')
                        ->required()
                        ->maxLength(255),
                ])
                ->defaultItems(2)
                ->columnSpanFull(),
            TextInput::make('about_button_text')
                ->label('Button Text')
                ->required()
                ->maxLength(255),
            TextInput::make('about_button_link')
                ->label('Button Link (URL)')
                ->url()
                ->maxLength(255),
            FileUpload::make('about_image')
                ->label('Image')
                ->directory('about')
                ->image()
                ->nullable(),
            // Stat Card 1
            TextInput::make('about_stat1_title')
                ->label('Stat Card 1 Title')
                ->maxLength(255),
            TextInput::make('about_stat1_value')
                ->label('Stat Card 1 Value')
                ->maxLength(255),
            TextInput::make('about_stat1_description')
                ->label('Stat Card 1 Description')
                ->maxLength(255),
            // Stat Card 2
            TextInput::make('about_stat2_title')
                ->label('Stat Card 2 Title')
                ->maxLength(255),
            TextInput::make('about_stat2_value')
                ->label('Stat Card 2 Value')
                ->maxLength(255),
            TextInput::make('about_stat2_description')
                ->label('Stat Card 2 Description')
                ->maxLength(255),
        ];
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        $settings = Setting::where('group', static::$settings)->pluck('value', 'key');

        $data['about_subtitle'] = $settings->get('about_subtitle');
        $data['about_title'] = $settings->get('about_title');
        $data['about_description'] = $settings->get('about_description');
        $data['about_list_items'] = $settings->get('about_list_items', []);
        $data['about_button_text'] = $settings->get('about_button_text');
        $data['about_button_link'] = $settings->get('about_button_link');
        $data['about_image'] = $settings->get('about_image');
        $data['about_stat1_title'] = $settings->get('about_stat1_title');
        $data['about_stat1_value'] = $settings->get('about_stat1_value');
        $data['about_stat1_description'] = $settings->get('about_stat1_description');
        $data['about_stat2_title'] = $settings->get('about_stat2_title');
        $data['about_stat2_value'] = $settings->get('about_stat2_value');
        $data['about_stat2_description'] = $settings->get('about_stat2_description');

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
