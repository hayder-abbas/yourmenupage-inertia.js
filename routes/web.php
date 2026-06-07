<?php

use App\Http\Controllers\CityController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RestaurantController;
use App\Http\Resources\RestaurantResource;
use App\Models\Restaurant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;


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
    Route::get('/dashboard', function (Request $request) {
        /** @todo: Search/Filter Items **/
        // $query = Item::query();
        // $request->validate([
        //     'field' => ['in:id,item_title,item_price,restaurant_id,category_id'],
        //     'direction' => ['in:asc,desc']
        // ]);
        // if ($request->search) {
        //     $query->where('item_title', 'like', "$request->search%");
        // }
        // if ($request->has(['field', 'direction'])) {
        //     $query->orderBy($request->field, $request->direction);
        // }

        return Inertia::render('Dashboard', [
            'restaurants' => RestaurantResource::collection(
                Restaurant::where('user_id', Auth::id())
                    ->select('id', 'rest_name')
                    ->get()
            ),
            'filters' => $request->all(['search', 'field', 'direction']),

        ]);
    })->name('dashboard');
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
