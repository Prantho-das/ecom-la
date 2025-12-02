<?php

namespace App\Filament\DarkAdmin\Pages\Settings;

use App\Filament\DarkAdmin\Pages\SiteSettings;
use App\Models\Setting;
use BackedEnum;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Pages\Page;
use Filament\Support\Icons\Heroicon;
use UnitEnum;

class ManageCTASettings extends Page
{
    use InteractsWithForms;
    protected static string|UnitEnum|null $navigationGroup = 'Settings';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static string $settings = 'cta';

    protected static ?string $title = 'Call to Action Section Settings';

    protected static ?string $slug = 'cta-settings';
    protected string $view = 'volt-livewire::filament.dark-admin.pages.settings.common-settings';

    public ?array $data = [];
    public function mount(): void
    {
        // Default values (prevents validation errors)
        $default = [
            'cta_title' => '',
            'cta_description' => '',
            'cta_button_text' => '',
            'cta_button_link' => '',
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
            ->schema(
                [
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
                ]
            );
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
