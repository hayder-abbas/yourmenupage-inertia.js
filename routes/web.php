<?php

use App\Http\Controllers\CityController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RestaurantController;
use App\Http\Resources\RestaurantResource;
use App\Models\Item;
use App\Models\Restaurant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::post('/resetprofileimage', [ProfileController::class, 'resetProfileImg'])
        ->name('reset.profile.image');

    Route::resource('restaurant', RestaurantController::class)
        ->except('index', 'show');
    Route::resource('item', ItemController::class)
        ->except('index', 'create', 'show');

    Route::get('/dashboard', function (Request $request) {
        $query = Item::query();
        $request->validate([
            'field' => ['in:id,item_title,item_price,restaurant_id,category_id'],
            'direction' => ['in:asc,desc']
        ]);
        if ($request->search) {
            $query->where('item_title', 'like', "$request->search%");
        }
        if ($request->has(['field', 'direction'])) {
            $query->orderBy($request->field, $request->direction);
        }

        return Inertia::render('Dashboard', [
            'restaurants' => RestaurantResource::collection(
                Restaurant::where('user_id', Auth::id())
                    ->select('id', 'rest_name')->get()
            ),
            'filters' => $request->all(['search', 'field', 'direction']),

        ]);
    })->name('dashboard');
});

Route::get('/', function (Request $request) {
    return Inertia::render('Home', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'restaurants' => RestaurantResource::collection(
            Restaurant::query()
                ->where('id', '>', 0)
                ->when($request->input('search'), function ($query, $search) {
                    $query->where('rest_name', 'like', "{$search}%");
                })->get()
        ),
        'filters' => $request->only(['search']),
    ]);
})->name('home');

Route::resource('city', CityController::class)->only('index', 'show');

Route::get('/restaurant/{restaurant}', [RestaurantController::class, 'show'])
    ->name('restaurant.show');

Route::inertia('/about', 'About')->name('about');

require __DIR__ . '/auth.php';
