<?php

namespace App\Providers\Filament;

use App\Filament\DarkAdmin\Pages\SiteSettings;
use App\Filament\Resources\Shield\RoleResource;
use App\Filament\DarkAdmin\Widgets\StatsOverview;
use BezhanSalleh\FilamentShield\FilamentShieldPlugin;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Navigation\NavigationGroup;
use Filament\Navigation\NavigationItem;
use Filament\Pages\Dashboard;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Support\Enums\Width;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class DarkAdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        $site_logo = getSetting('logo', null);

        return $panel
            ->id('dark-admin')
            ->path('dark-admin')
            ->login()
            ->default()
            ->colors([
                'primary' => Color::Green,
            ])
            ->spa()
            ->globalSearch(false)
            ->sidebarCollapsibleOnDesktop()
            ->brandLogo(function () use ($site_logo) {
                if (! empty($site_logo)) {
                    $logoUrl = asset('storage/'.$site_logo);

                    return new \Illuminate\Support\HtmlString(
                        '<img src="'.e($logoUrl).'" alt="Site Logo" class="w-auto h-10 transition-transform duration-200 rounded-lg shadow-sm hover:scale-105">'
                    );
                }

                return new \Illuminate\Support\HtmlString('
                    <div class="flex items-center justify-center w-10 h-10 text-lg font-bold text-white bg-red-600 rounded-lg">
                        B
                    </div>
                ');
            })
            ->profile()
            ->maxContentWidth(Width::Full)
            ->sidebarWidth('16rem')
            ->navigationItems([
                NavigationItem::make()
                    ->label('Clear Cache')
                    ->icon('heroicon-o-trash')
                    ->url(url: url('clear-cache'))
                    ->sort(999),
            ])
            ->navigationGroups([
                NavigationGroup::make('Sales & CRM')
                    ->icon('heroicon-o-currency-dollar')
                    ->collapsible(),
                NavigationGroup::make('Product Catalog')
                    ->icon('heroicon-o-shopping-bag')
                    ->collapsible(),
                NavigationGroup::make('Inventory Management')
                    ->icon('heroicon-o-archive-box')
                    ->collapsible(),
                NavigationGroup::make('Website Content')
                    ->icon('heroicon-o-document-text')
                    ->collapsible(),
                NavigationGroup::make('System Settings')
                    ->icon('heroicon-o-cog-6-tooth')
                    ->collapsible(),
            ])
            ->renderHook(
                \Filament\View\PanelsRenderHook::HEAD_END,
                fn (): string => \Illuminate\Support\Facades\Blade::render('
                    @vite(\'resources/css/app.css\')
                    <style>
                        a[href*="clear-cache"] {
                            background-color: #dc2626 !important;
                            color: white !important;
                            border-radius: 0.5rem !important;
                            margin-top: 1rem !important;
                            transition: background-color 0.2s !important;
                            padding: 0.5rem !important;
                            font-weight: bold !important;
                        }
                        a[href*="clear-cache"]:hover {
                            background-color: #b91c1c !important;
                        }
                        a[href*="clear-cache"] svg {
                            color: white !important;
                        }
                        a[href*="clear-cache"] span {
                            color: white !important;
                        }
                    </style>
                ')
            )
            ->discoverResources(in: app_path('Filament/DarkAdmin/Resources'), for: 'App\Filament\DarkAdmin\Resources')
            ->discoverPages(in: app_path('Filament/DarkAdmin/Pages'), for: 'App\Filament\DarkAdmin\Pages')
            ->pages([
                Dashboard::class,
                SiteSettings::class,
            ])
            ->discoverWidgets(in: app_path('Filament/DarkAdmin/Widgets'), for: 'App\Filament\DarkAdmin\Widgets')
            ->widgets([
                \App\Filament\DarkAdmin\Widgets\QuotationChart::class,
                \App\Filament\DarkAdmin\Widgets\CategoryChart::class,
                StatsOverview::class,
            ])
            ->resources([
                RoleResource::class,
            ])
            ->plugins(
                class_exists(FilamentShieldPlugin::class)
                    ? [FilamentShieldPlugin::make()]
                    : []
            )
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ]);
    }
}
