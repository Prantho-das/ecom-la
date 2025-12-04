<?php

namespace App\Filament\DarkAdmin\Pages\Settings;

use App\Filament\DarkAdmin\Pages\SiteSettings;
use App\Models\Setting;
use BackedEnum;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Pages\Page;
use Filament\Support\Icons\Heroicon;
use UnitEnum;

class ManageFeaturesSettings extends Page
{
    use InteractsWithForms;
    protected static string|UnitEnum|null $navigationGroup = 'Settings';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static string $settings = 'features';

    protected static ?string $title = 'Features Section Settings';

    protected static ?string $slug = 'features-settings';
    protected string $view = 'volt-livewire::filament.dark-admin.pages.settings.common-settings';

    public ?array $data = [];

    public function mount(): void
    {
        // Default values (prevents validation errors)
        $default = [
            'icon' => '',
            'title' => '',
            'description' => '',
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
            Repeater::make('features_list')
                ->label('Features')
                ->schema([
                    TextInput::make('icon')
                        ->label('Icon (Emoji or Icon Class)')
                        ->required()
                        ,
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
        ]);
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
    public function save(): void
    {
        $data = $this->form->getState();

       $this->mutateFormDataBeforeSave($data);
        \Filament\Notifications\Notification::make()
            ->title('Saved Successfully')
            ->body('Features section settings updated.')
            ->success()
            ->send();
    }
}
