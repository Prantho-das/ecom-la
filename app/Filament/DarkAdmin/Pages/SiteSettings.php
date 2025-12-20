<?php

namespace App\Filament\DarkAdmin\Pages;

use BackedEnum;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Support\Icons\Heroicon;
use Illuminate\Support\Facades\DB;

class SiteSettings extends Page
{
    use InteractsWithForms;

    protected string $view = 'volt-livewire::filament.dark-admin.pages.site-settings';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public $site_title;

    public $site_name;

    public $site_email;

    public $meta_title;

    public $meta_description;
    public $service_page_description;

    public $logo; // will store file path

    public $current_logo; // will store file path

    public function mount(): void
    {
        // Load existing settings from DB
        $this->site_title = $this->getSetting('general', 'site_title') ?? '';
        $this->site_name = $this->getSetting('general', 'site_name') ?? '';
        $this->site_email = $this->getSetting('general', 'site_email') ?? '';
        $this->meta_title = $this->getSetting('general', 'meta_title') ?? '';
        $this->meta_description = $this->getSetting('general', 'meta_description') ?? '';
        $this->logo = $this->getSetting('general', 'logo') ?? '';
        $this->current_logo = $this->getSetting('general', 'logo') ?? '';
        $this->service_page_description=$this->getSetting('general','service_page_description')??'';

        $this->form->fill([
            'site_title' => $this->site_title,
            'site_name' => $this->site_name,
            'site_email' => $this->site_email,
            'meta_title' => $this->meta_title,
            'meta_description' => $this->meta_description,
            'logo' => $this->logo,
        ]);
    }

    protected function getFormSchema(): array
    {
        return [
            TextInput::make('site_title')
                ->label('Site Title')
                ->required(),

            TextInput::make('site_name')
                ->label('Site Name')
                ->required(),

            TextInput::make('site_email')
                ->label('Site Email')
                ->email()
                ->required(),

            TextInput::make('meta_title')
                ->label('Meta Title'),

            Textarea::make('meta_description')
                ->label('Meta Description')
                ->rows(3),
            Textarea::make('service_page_description')
                ->label('service page Description')
                ->rows(3),

            FileUpload::make('logo')
                ->label('Site Logo')
                ->image()
                ->directory('site-logos')
                ->nullable()
                ->preserveFilenames()
                ->disk('public')
                ->maxSize(1024) // max 1MB
                ->hint('Upload site logo image'),
        ];
    }

    public function save()
    {
        $data = $this->form->getState();

        // Save text settings
        $this->setSetting('general', 'site_title', $data['site_title']);
        $this->setSetting('general', 'site_name', $data['site_name']);
        $this->setSetting('general', 'site_email', $data['site_email']);
        $this->setSetting('general', 'meta_title', $data['meta_title']);
        $this->setSetting('general', 'meta_description', $data['meta_description']);
        $this->setSetting('general', 'service_page_description', $data['service_page_description']);

        // Handle logo upload path save
        if (! empty($data['logo'])) {

            $logoPath = is_string($data['logo']) ? $data['logo'] : $data['logo']->store('site-logos');
            $this->setSetting('general', 'logo', $logoPath);
        }

        Notification::make()
            ->title('Settings saved successfully')
            ->success()
            ->send();
    }

    protected function getSetting(string $group, string $key)
    {
        $setting = DB::table('settings')
            ->where('group', $group)
            ->where('key', $key)
            ->first();

        return $setting ? $setting->value : null;
    }

    protected function setSetting(string $group, string $key, $value): void
    {
        DB::table('settings')->updateOrInsert(
            ['group' => $group, 'key' => $key],
            ['value' => $value, 'type' => 'string']
        );
    }
}
