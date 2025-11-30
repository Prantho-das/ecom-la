<?php

use App\Livewire\Frontend\Category;
use App\Livewire\Frontend\Contact;
use App\Livewire\Frontend\Details;
use App\Livewire\Frontend\Home;
use App\Livewire\Frontend\ResellerPartner;
use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Features;
use Livewire\Volt\Volt;
use Illuminate\Support\Facades\Artisan;
use Filament\Notifications\Notification;

// Route::get('/', function () {
//     return view('welcome');
// })->name('home');


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



// Route::get('/', function () {
//     return view('home'); // Returns the 'about.blade.php' view
// });

// Route::get('/category', function () {
//     return view('category'); // Returns the 'about.blade.php' view
// });

// Route::get('/contact', function () {
//     return view('contact'); // Returns the 'about.blade.php' view
// });

// Route::get('/reseller-partner', function () {
//     return view('reseller-partner'); // Returns the 'about.blade.php' view
// });

// Route::get('/details', function () {
//     return view('details'); // Returns the 'about.blade.php' view
// });



// HOME
Route::get('/', Home::class)->name('home');

// CATEGORY
Route::get('/category', Category::class)->name('category');

// CONTACT
Route::get('/contact', Contact::class)->name('contact');

// RESELLER PARTNER
Route::get('/reseller-partner', ResellerPartner::class)->name('reseller.partner');

// PRODUCT DETAILS (Dynamic Route)
Route::get('/details/{slug}', Details::class)->name('details');
