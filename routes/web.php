<?php

use App\Http\Controllers\CityController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RestaurantController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::controller(ProfileController::class)->group(function () {
        Route::get('/profile', 'edit')->name('profile.edit');
        Route::patch('/profile', 'update')->name('profile.update');
        Route::delete('/profile', 'destroy')->name('profile.destroy');
        Route::post('/reset/profile/image', 'resetProfileImg')->name('reset.profile.image');
    });

    Route::resource('restaurants', RestaurantController::class)->except(['show']);

    Route::controller(ItemController::class)->group(function () {
        Route::get('/items/trashed', 'trashed')->name('items.trashed');
        Route::patch('/items/{item}/restore', 'restore')->name('items.restore')->withTrashed();
        Route::delete('/items/{item}/force-delete', 'forceDelete')->name('items.forceDelete')->withTrashed();
    });
    Route::resource('items', ItemController::class)->except(['index', 'show']);

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
});

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::controller(CityController::class)->group(function () {
    Route::get('/cities', 'index')->name('cities.index');
    Route::get('/cities/{city}', 'show')->name('cities.show');
});

Route::get('/restaurants/{restaurant}', [RestaurantController::class, 'show'])
    ->name('restaurants.show');

Route::inertia('/about', 'About')->name('about');

require __DIR__ . '/auth.php';
