<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

// Settings controllers
use App\Http\Controllers\Settings\ProfileController;
use App\Http\Controllers\Settings\PasswordController;
use App\Http\Controllers\Settings\MediaController;
use App\Http\Controllers\Settings\BabysitterProfileController;
use App\Http\Controllers\Settings\SetAsProfilePhotoController;
use App\Http\Controllers\Settings\DeleteProfilePhotoController;

Route::middleware('auth')
    ->prefix('settings')
    ->name('settings.')
    ->group(function () {
        // Redirect /settings → /settings/profile
        Route::redirect('/', 'settings/profile');

        // Profile CRUD
        Route::get('profile',   [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

        // Password update
        Route::get('password', [PasswordController::class, 'edit'])->name('password.edit');
        Route::put('password', [PasswordController::class, 'update'])->name('password.update');

        // Media management
        Route::get('media',                    [MediaController::class, 'index'])->name('media.list');
        Route::post('media',                   [MediaController::class, 'store'])->name('media.store');
        Route::post('media/{media}/set-profile', SetAsProfilePhotoController::class)->name('media.setProfile');
        Route::delete('media/{media}',         DeleteProfilePhotoController::class)->name('media.delete');

        // Babysitter profile details
        Route::get('babysitter/profile/details', [BabysitterProfileController::class, 'edit'])
            ->name('babysitter.profile.details');
        Route::patch('babysitter/profile/details', [BabysitterProfileController::class, 'update'])
            ->name('babysitter.profile.update');

        // Appearance settings
        Route::get('appearance', fn() => Inertia::render('settings/appearance'))
            ->name('appearance');
    });
