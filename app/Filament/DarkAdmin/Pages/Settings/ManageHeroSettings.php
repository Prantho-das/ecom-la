<?php

namespace App\Filament\DarkAdmin\Pages\Settings;

use App\Models\Setting;
use Filament\Forms;
use Filament\Pages\Page;
use Filament\Support\Icons\Heroicon;
use Filament\Notifications\Notification;
use UnitEnum;
use BackedEnum;
use Livewire\Form;
use Filament\Forms\Concerns\InteractsWithForms;
class ManageHeroSettings extends Page
{
    use InteractsWithForms;
    protected static string|UnitEnum|null $navigationGroup = 'Settings';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $title = 'Hero Section Settings';

    protected static ?string $slug = 'hero-settings';

    protected static string $settings = 'hero';

    protected string $view = 'volt-livewire::filament.dark-admin.pages.settings.common-settings';

    public ?array $data = [];

    public function mount(): void
    {
        // Default values (prevents validation errors)
        $default = [
            'hero_title' => '',
            'hero_subtitle' => '',
            'hero_cta_text' => '',
            'hero_cta_link' => '',
            'hero_background_image' => null,
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
                Forms\Components\TextInput::make('hero_title')
                    ->label('Title')
                    ->required(),

                Forms\Components\TextInput::make('hero_subtitle')
                    ->label('Subtitle'),

                Forms\Components\TextInput::make('hero_cta_text')
                    ->label('Button Text'),

                Forms\Components\TextInput::make('hero_cta_link')
                    ->label('Button URL')
                    ->url(),

                Forms\Components\FileUpload::make('hero_background_image')
                    ->label('Background Image')
                    ->image()
                    ->directory('hero')
                    ->disk('public')
                    ->nullable(),
            ]);
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
