<?php

use App\Http\Controllers\CityController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RestaurantController;
use Illuminate\Support\Facades\Route;


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::post('/reset/profile/image', [ProfileController::class, 'resetProfileImg'])
        ->name('reset.profile.image');

    /** Item Resource **/
    Route::get('/items/trashed', [ItemController::class, 'trashed'])
        ->name('items.trashed');
    Route::patch('/items/{item}/restore', [ItemController::class, 'restore'])
        ->name('items.restore')
        ->withTrashed();
    Route::delete('/items/{item}/force-delete', [ItemController::class, 'forceDelete'])
        ->name('items.forceDelete')
        ->withTrashed();
    Route::resource('items', ItemController::class)
        ->except(['index', 'show']);

    /** Dashboard Route **/
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
});

/** Home Route **/
Route::get('/', [HomeController::class, 'index'])->name('home');

/** City Resource **/
Route::get('/cities', [CityController::class, 'index'])->name('cities.index');
Route::get('/cities/{city}', [CityController::class, 'show'])->name('cities.show');

/** Restaurant Resource **/
Route::resource('restaurants', RestaurantController::class)
    ->only(['create', 'store', 'edit', 'update', 'destroy'])
    ->middleware('auth');
Route::get('/restaurants/{restaurant}', [RestaurantController::class, 'show'])
    ->name('restaurants.show');

Route::inertia('/about', 'About')->name('about');

require __DIR__ . '/auth.php';
