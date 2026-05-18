<?php

use App\Http\Controllers\CityController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RestaurantController;
use App\Http\Resources\RestaurantResource;
use App\Models\Item;
use App\Models\Restaurant;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

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

    Route::resource('restaurant', RestaurantController::class);
    Route::resource('item', ItemController::class);

    /**
     * Reset profile image
     */
    Route::post('/resetprofileimage', function () {
        $user = User::findOrFail(Auth::id());
        if ($user['user_image'] !== null) {
            User::where('id', Auth::id())->update(['user_image' => '']);
            Storage::disk('public')->delete($user['user_image']);
        }
        return to_route('profile.edit')->with('status', 'image-reset');
    })->name('reset.profile.image');
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

Route::get('/city', [CityController::class, 'index'])
    ->name('city.index');
Route::get('/city/{city}', [CityController::class, 'show'])
    ->name('city.show');

Route::get('/restaurants/{restaurant}', [RestaurantController::class, 'show'])
    ->name('restaurant.show');

Route::get('items/{item}', [ItemController::class, 'show'])
    ->name('item.show');

Route::inertia('/about', 'About')->name('about');

require __DIR__ . '/auth.php';
