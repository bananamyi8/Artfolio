
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\RoleSelectionController;
use App\Http\Controllers\ArtistProfileController;
use Livewire\Volt\Volt;

// Public homepage
Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/artfolio', [HomeController::class, 'index'])
    ->name('artfolio.home');

// Default Laravel dashboard
Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// Authentication settings
Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Volt::route('settings/profile', 'settings.profile')
        ->name('settings.profile');

    Volt::route('settings/password', 'settings.password')
        ->name('settings.password');

    Volt::route('settings/appearance', 'settings.appearance')
        ->name('settings.appearance');

    // Role selection
    Route::get('/choose-role', [RoleSelectionController::class, 'show'])
        ->name('role.show');

    Route::post('/choose-role', [RoleSelectionController::class, 'store'])
        ->name('role.store');

    // Favorite an artwork
    Route::post('/artworks/{artwork}/favorite', [FavoriteController::class, 'toggle'])
        ->name('artworks.favorite');
});

// Member dashboard
Route::get('/member/dashboard', function () {
    return view('artfolio.dashboard');
})->middleware('auth')->name('member.dashboard');

// Artist pages
Route::middleware(['auth', 'role:artist'])->group(function () {

    Route::view('/artist/dashboard', 'artfolio.artist-dashboard')
        ->name('artist.dashboard');

    Route::get('/artist/profile', [ArtistProfileController::class, 'show'])
        ->name('artist.profile');

    Route::get('/artist/settings', [ArtistProfileController::class, 'edit'])
        ->name('artist.settings');

    Route::put('/artist/profile', [ArtistProfileController::class, 'update'])
        ->name('artist.profile.update');

    Route::view('/artist/artworks', 'artfolio.artist-artworks')
        ->name('artist.artworks');

    Route::view('/artist/exhibitions', 'artfolio.artist-exhibitions')
        ->name('artist.exhibitions');

    Route::view('/artist/favorites', 'artfolio.artist-favorites')
        ->name('artist.favorites');

});

// Admin dashboard
Route::get('/admin/dashboard', function () {
    return view('artfolio.dashboard');
})->middleware(['auth', 'role:admin'])
  ->name('admin.dashboard');

// Visitor dashboard
Route::get('/visitor/dashboard', function () {
    return view('artfolio.dashboard');
})->middleware(['auth', 'role:visitor'])
  ->name('visitor.dashboard');

require __DIR__.'/auth.php';
