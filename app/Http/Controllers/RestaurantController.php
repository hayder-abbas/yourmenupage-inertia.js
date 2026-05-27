<?php

namespace App\Http\Controllers;

use App\Models\Restaurant;
use App\Http\Requests\StoreRestaurantRequest;
use App\Http\Requests\UpdateRestaurantRequest;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\CityResource;
use App\Http\Resources\ItemResource;
use App\Http\Resources\RestaurantResource;
use App\Models\Category;
use App\Models\City;
use App\Models\Item;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Gate;
use Inertia\Inertia;

class RestaurantController extends Controller
{
    public function create()
    {
        Gate::authorize('create', Restaurant::class);

        return Inertia::render("Restaurant/Create", [
            'cities' => CityResource::collection(City::all())
        ]);
    }


    public function store(StoreRestaurantRequest $request)
    {
        Gate::authorize('create', Restaurant::class);

        $fields = $request->validated();
        $logoPath = null;

        try {
            if ($request->hasFile('rest_logo')) {
                $logoPath = $request->file('rest_logo')
                    ->store('restaurant_logo', 'public');
                $fields['rest_logo'] = $logoPath;
            }

            $restaurant = Restaurant::create($fields);
        } catch (\Exception $ex) {
            if ($logoPath) {
                Storage::disk('public')->delete($logoPath);
            }
            throw $ex;
        }

        return to_route('restaurant.show', $restaurant)
            ->with('status', 'restaurant-created');
    }


    public function show(Restaurant $restaurant)
    {
        Gate::authorize('view', $restaurant);

        return Inertia::render('Restaurant/Show', [
            'restaurant' => new RestaurantResource($restaurant),
            'items' => ItemResource::collection($restaurant->items),
            'categories' => CategoryResource::collection(
                Cache::remember('categories', 3600, fn() => Category::all('id', 'cat_name'))
            ),
            'can' => [
                'update' => Gate::allows('update', $restaurant),
                'manageItems' => Gate::allows('manageItems', $restaurant)
            ]
        ]);
    }


    public function edit(Restaurant $restaurant)
    {
        Gate::authorize('update', $restaurant);

        return Inertia::render("Restaurant/Edit", [
            'restaurant' => new RestaurantResource($restaurant),
            'cities' => CityResource::collection(
                City::all('id', 'city_name')
            )
        ]);
    }


    public function update(UpdateRestaurantRequest $request, Restaurant $restaurant)
    {
        Gate::authorize('update', $restaurant);

        $fields = $request->validated();
        $newLogo = null;
        $oldLogo = $restaurant->rest_logo; // capture before update

        try {
            if ($request->hasFile('rest_logo')) {
                // 1. Store new logo (may throw exception)
                $newLogo = $request->file('rest_logo')
                    ->store('restaurant_logo', 'public');
                $fields['rest_logo'] = $newLogo;
            } else {
                // 2. If no new logo, remove the key to keep existing one
                unset($fields['rest_logo']);
            }
            // 3. Update the restaurant (database operation)
            $restaurant->update($fields);

            // 4. Delete old logo only after successful update
            if ($newLogo && $oldLogo) {
                Storage::disk('public')->delete($oldLogo);
            }
        } catch (\Exception $ex) {
            // If anything failed after storing the new logo, clean it up
            if ($newLogo) {
                Storage::disk('public')->delete($newLogo);
            }
            throw $ex;
        }

        return to_route('restaurant.show', $restaurant)
            ->with('status', 'restaurant-updated');
    }


    public function destroy(Request $request, Restaurant $restaurant)
    {
        Gate::authorize('delete', $restaurant);

        $request->validate([
            'password' => ['required', 'current_password'],
        ]);

        $restaurant->delete();

        if ($restaurant->rest_logo) {
            Storage::disk('public')->delete($restaurant->rest_logo);
        }

        $itemImageDir = 'item_image/' . $restaurant->id;
        if (Storage::disk('public')->exists($itemImageDir)) {
            Storage::disk('public')->deleteDirectory($itemImageDir);
        }

        return to_route('dashboard')->with('status', 'restaurant-deleted');
    }
}
