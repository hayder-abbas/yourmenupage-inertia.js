<?php

use App\Http\Controllers\CityController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RestaurantController;
use App\Http\Resources\ItemResource;
use App\Models\Item;
use App\Models\Restaurant;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;


Route::middleware('auth')->group(function () {
  Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
  Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
  Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
  Route::post('/profile', [ProfileController::class, 'resetImage'])->name('profile.resetImage');

  Route::get('/dashboard', function (Request $request) {
    $query = Item::query();
    $request->validate([
      'field' => ['in:id,title,category_id,price,restaurant_id'],
      'direction' => ['in:asc,desc']
    ]);

    if ($request->search) {
      $query->where('title', 'LIKE', "$request->search%");
    }

    if ($request->has(['field', 'direction'])) {
      $query->orderBy($request->field, $request->direction);
    }

    return Inertia::render('Dashboard', [
      'restaurants' => DB::table('restaurants')
        ->where('user_id', Auth::id())
        ->select('id', 'name')
        ->get(),

      'items' => ItemResource::collection(
        $query->where('user_id', Auth::id())->paginate(10)
      ),

      'filters' => $request->all(['search', 'field', 'direction']),

    ]);
  })->name('dashboard');

  Route::resource('restaurants', RestaurantController::class);

  Route::resource('items', ItemController::class);

  Route::post('/resetprofileimage', function () {
    $getUser = User::findOrFail(Auth::id());
    User::where('id', Auth::id())->update(['image' => '']);
    Storage::disk('public')->delete($getUser['image']);
    return to_route('profile.edit');
  })->name('reset.profile.image');
});

Route::get('/', function (Request $request) {
  return Inertia::render('Home', [
    'canLogin' => Route::has('login'),
    'canRegister' => Route::has('register'),
    'restaurants' => Restaurant::query()
      ->where('id', '>', 0)
      ->when($request->input('search'), function ($query, $search) {
        $query->where('name', 'like', "{$search}%");
      })->get(['id', 'name', 'location']),
    'filters' => $request->only(['search']),
  ]);
})->name('home');

Route::get('/cities', [CityController::class, 'index'])->name('cities');
Route::get('/cities/{city}', [CityController::class, 'show'])->name('city.show');

Route::get('/restaurants/{restaurant}', [RestaurantController::class, 'show'])
  ->name('restaurant.show');

Route::get('items/{item}', [ItemController::class, 'show'])->name('item.show');

Route::inertia('/about', 'About')->name('about');

require __DIR__ . '/auth.php';
