<?php

namespace App\Filament\DarkAdmin\Pages\Settings;

use App\Filament\DarkAdmin\Pages\SiteSettings;
use App\Models\Setting;
use BackedEnum;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Pages\Page;
use Filament\Support\Icons\Heroicon;
use UnitEnum;
use Filament\Notifications\Notification;
use Filament\Schemas\Components\Section;
use Filament\Tables\Columns\Layout\Grid;

class ManageChooseUsSettings extends Page
{
    use InteractsWithForms;
    protected static string|UnitEnum|null $navigationGroup = 'Settings';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static string $settings = 'choose-us';

    protected static ?string $title = 'choose-us';

    protected static ?string $slug = 'choose-us-settings';
    protected string $view = 'volt-livewire::filament.dark-admin.pages.settings.common-settings';

    public ?array $data = [];
    public function mount(): void
    {
        $default = [
            'choose-use_subtitle' => '',
            'choose-use_title' => '',
            'choose-use_image' => null,
            'choose-use_stat1_title' => '',
            'choose-use_stat1_description' => '',
            'choose-use_stat2_title' => '',
            'choose-use_stat2_description' => '',
        ];

        $settings = Setting::where('group', static::$settings)
            ->pluck('value', 'key');

        // Decode JSON fields if stored as JSON (like about_list_items)
        $about_list_items = $settings->get('about_list_items');
        // if ($about_list_items) {
        //     $about_list_items = json_decode($about_list_items, true);
        // } else {
        //     $about_list_items = [];
        // }

        $this->data = array_merge($default, [
            'choose-use_subtitle' => $settings->get('choose-use_subtitle', ''),
            'choose-use_title' => $settings->get('choose-use_title', ''),
            'choose-use_image' => $settings->get('choose-use_image', ''),
            'choose-use_stat1_title' => $settings->get('choose-use_stat1_title', ''),
            'choose-use_stat1_description' => $settings->get('choose-use_stat1_description', ''),
            'choose-use_stat2_title' => $settings->get('choose-use_stat2_title', ''),
            'choose-use_stat2_description' => $settings->get('choose-use_stat2_description', null),
        ]);
        $this->form->fill($this->data);
    }
    public function form($form)
    {
        return $form
            ->statePath('data')
            ->schema(
                [

                    TextInput::make('choose-use_subtitle')
                        ->label('Subtitle')
                        ->placeholder('e.g. Why Choose Us')
                        ->maxLength(255),

                    TextInput::make('choose-use_title')
                        ->label('Main Title')
                        ->placeholder('e.g. We Create Beautiful Experiences')
                        ->maxLength(255),


                    FileUpload::make('choose-use_image')
                        ->label('Background Image')
                        ->image()
                        ->directory('settings')
                        ->visibility('public')
                        ->disk('public')
                        ->preserveFilenames()
                        ->maxSize(5120) // 5MB
                        ->helperText('Recommended: 1280x850px or larger, JPG/PNG/WebP')
                        ->columnSpanFull(),

                    FileUpload::make('choose-use_image_two')
                        ->label('Background Image Two')
                        ->image()
                        ->directory('settings')
                        ->visibility('public')
                        ->disk('public')
                        ->preserveFilenames()
                        ->maxSize(5120) // 5MB
                        ->helperText('Recommended: 1280x850px or larger, JPG/PNG/WebP')
                        ->columnSpanFull(),


                    TextInput::make('choose-use_stat1_title')
                        ->label('Stat 1 Title')
                        ->placeholder('e.g. 10K+')
                        ->maxLength(100),

                    TextInput::make('choose-use_stat1_description')
                        ->label('Stat 1 Description')
                        ->placeholder('e.g. Happy Clients')
                        ->maxLength(255),

                    TextInput::make('choose-use_stat2_title')
                        ->label('Stat 2 Title')
                        ->placeholder('e.g. 300+')
                        ->maxLength(100),

                    TextInput::make('choose-use_stat2_description')
                        ->label('Stat 2 Description')
                        ->placeholder('e.g. Projects Completed')
                        ->maxLength(255),
                ]
            );
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        $settings = Setting::where('group', static::$settings)->pluck('value', 'key');

        $data['choose-use_subtitle'] = $settings->get('choose-use_subtitle');
        $data['choose-use_title'] = $settings->get('choose-use_title');
        $data['choose-use_image'] = $settings->get('choose-use_image');
        $data['choose-use_stat1_title'] = $settings->get('choose-use_stat1_title');
        $data['choose-use_stat1_description'] = $settings->get('choose-use_stat1_description');
        $data['choose-use_stat2_title'] = $settings->get('choose-use_stat2_title');
        $data['choose-use_stat2_description'] = $settings->get('choose-use_stat2_description');

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
        // We manually save each setting, encoding repeater as JSON
        $data = $this->form->getState();

        $this->mutateFormDataBeforeSave($data);

        Notification::make()
            ->title('Saved Successfully')
            ->body('About section settings updated.')
            ->success()
            ->send();
    }
}
