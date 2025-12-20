<?php

use App\Livewire\Frontend\Category;
use App\Livewire\Frontend\Contact;
use App\Livewire\Frontend\Details;
use App\Livewire\Frontend\Home;
use App\Livewire\Frontend\ResellerPartner;
use App\Livewire\Frontend\ServiceCategoryIndex;
use App\Livewire\Frontend\ServiceCategoryShow;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Features;
use Livewire\Volt\Volt;

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
