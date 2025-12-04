<?php

namespace App\Filament\DarkAdmin\Pages\Settings;

use App\Models\Setting;
use BackedEnum;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\TextInput;
use Filament\Support\Icons\Heroicon;
use UnitEnum;
use App\Filament\DarkAdmin\Pages\SiteSettings;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Notifications\Notification;
use Filament\Pages\Page;

class ManageSocialMediaSettings extends Page
{
    use InteractsWithForms;
    protected static string|UnitEnum|null $navigationGroup = 'Settings';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static string $settings = 'social_media';

    protected static ?string $title = 'Social Media Links';

    protected static ?string $slug = 'social-media-settings';

    protected string $view = 'volt-livewire::filament.dark-admin.pages.settings.common-settings';


    public ?array $data = [];

    public function mount(): void
    {
        // Default values (prevents validation errors)
        $default = [
            'platform' => '',
            'url' => '',
            'icon' => '',
        ];

        // Load settings from DB
        $settings = Setting::where('group', static::$settings)
            ->pluck('value', 'key')
            ->toArray();

        // Merge defaults + DB values
        $this->form->fill(array_merge($default, $settings));
    }
    public function form($form)
    {
        return $form
            ->statePath('data')
            ->schema([
            Repeater::make('social_media_links')
                ->label('Social Media Links')
                ->schema([
                    TextInput::make('platform')
                        ->label('Platform (e.g., Facebook, Twitter)')
                        ->required()
                        ->maxLength(255),
                    TextInput::make('url')
                        ->label('Profile URL')
                        ->url()
                        ->required()
                        ->maxLength(255),
                    TextInput::make('icon')
                        ->label('Icon (e.g., fab fa-facebook-f or emoji)')
                        ->required()
                        ->maxLength(255),
                ])
                ->defaultItems(0)
                ->columnSpanFull(),
        ]);
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        $settings = Setting::where('group', static::$settings)->pluck('value', 'key');

        $data['social_media_links'] = $settings->get('social_media_links', []);

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
    public function save(): void
    {
        $data = $this->form->getState();

        foreach ($data as $key => $value) {
            Setting::updateOrCreate(
                [
                    'group' => static::$settings,
                    'key' => $key
                ],
                [
                    'value' => $value
                ]
            );
        }

        Notification::make()
            ->title('Saved Successfully')
            ->body('Hero section settings updated.')
            ->success()
            ->send();
    }
}
