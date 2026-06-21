<?php

use App\Livewire\Frontend\Category;
use App\Livewire\Frontend\Contact;
use App\Livewire\Frontend\Details;
use App\Livewire\Frontend\Home;
use App\Livewire\Frontend\ResellerPartner;
use App\Livewire\Frontend\ServiceCategoryIndex;
use App\Livewire\Frontend\ServiceCategoryShow;
use App\Livewire\SolutionCategory;
use App\Livewire\SolutionShow;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Features;
use Livewire\Volt\Volt;
use Rats\Zkteco\Lib\ZKTeco;

Route::get('/test-finger', function () {

    //  1 s't parameter is string $ip Device IP Address
    //  2 nd  parameter is integer $port Default: 4370

    $zk = new ZKTeco('192.168.0.145');
    $zk->connect();

    dd($zk);
    //  or you can use with port
    //    $zk = new ZKTeco('192.168.1.201', 8080);
});

Route::get('/clear-cache', function () {
    Artisan::call('cache:clear');
    Artisan::call('config:clear');
    Artisan::call('view:clear');
    Artisan::call('route:clear');

    Notification::make()
        ->title('Cache cleared successfully!')
        ->success()
        ->send();

    return redirect()->back();
})->name('clear-cache');
Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Volt::route('settings/profile', 'settings.profile')->name('profile.edit');
    Volt::route('settings/password', 'settings.password')->name('user-password.edit');
    Volt::route('settings/appearance', 'settings.appearance')->name('appearance.edit');

    Volt::route('settings/two-factor', 'settings.two-factor')
        ->middleware(
            when(
                Features::canManageTwoFactorAuthentication()
                    && Features::optionEnabled(Features::twoFactorAuthentication(), 'confirmPassword'),
                ['password.confirm'],
                [],
            ),
        )
        ->name('two-factor.show');
});

// HOME
Route::get('/', Home::class)->name('home');

// SERVICES
Route::get('/services', ServiceCategoryIndex::class)->name('services.index');
Route::get('/services/{slug}', ServiceCategoryShow::class)->name('services.show');

Route::get('/solutions', SolutionCategory::class)->name('solutions.index');
Route::get('/solutions/{slug}', SolutionShow::class)->name('solutions.show');

// CATEGORY
Route::get('/category/{category_slug?}', Category::class)->name('category');

// CONTACT
Route::get('/contact', Contact::class)->name('contact');

// RESELLER PARTNER
Route::get('/reseller-partner', ResellerPartner::class)->name('reseller.partner');

// PRODUCT DETAILS (Dynamic Route)
Route::get('/details/{product:slug}', Details::class)->name('details');

// BLOG POST DETAILS (Dynamic Route)
Route::get('/blog/{post:slug}', App\Livewire\Frontend\BlogPostDetail::class)->name('blog.show');
Route::get('/p/{page:slug}', App\Livewire\Frontend\PageDetail::class)->name('page.show');

Route::get('/debug-shield', function () {
    $resourceClass = 'App\Filament\DarkAdmin\Resources\Roles\RoleResource';
    if (! class_exists($resourceClass)) {
        return 'RoleResource not found';
    }

    try {
        $reflector = new \ReflectionClass($resourceClass);
        $filePath = $reflector->getFileName();

        return [
            'filePath' => $filePath,
            'filamentAuthGuard' => \BezhanSalleh\FilamentShield\Support\Utils::getFilamentAuthGuard(),
            'samplePermissions' => \BezhanSalleh\FilamentShield\Facades\FilamentShield::getResourcePermissionsWithLabels('App\\Filament\\DarkAdmin\\Resources\\Brands\\BrandResource'),
            'sampleDbPermission' => \Spatie\Permission\Models\Permission::first(),
        ];
    } catch (\Exception $e) {
        return 'Error: '.$e->getMessage();
    }
});
