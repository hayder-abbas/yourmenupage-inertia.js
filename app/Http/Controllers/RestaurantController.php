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
use App\Models\RestaurantPhone;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Inertia\Inertia;

class RestaurantController extends Controller
{
    public function create()
    {
        return Inertia::render("Restaurant/Create", [
            'cities' => CityResource::collection(City::all())
        ]);
    }


    public function store(StoreRestaurantRequest $request)
    {
        $fields = $request->validated();
        $newFields = array_filter($fields, function ($key) {
            return $key !== 'phone';
        }, ARRAY_FILTER_USE_KEY);

        if ($request->hasFile('rest_logo')) {
            $newFields['rest_logo'] = Storage::disk('public')
                ->put('restaurant_logo', $request->rest_logo);
        }

        $newRestaurant = Restaurant::create($newFields);
        RestaurantPhone::create([
            'phone_number' => $request->phone,
            'restaurant_id' => $newRestaurant->id
        ]);
        return to_route('dashboard')->with('status', 'restaurant-created');
    }


    public function show(Restaurant $restaurant)
    {
        $restaurant->load('items');

        return Inertia::render('Restaurant/Show', [
            'restaurant' => new RestaurantResource($restaurant),
            'items' => ItemResource::collection($restaurant->items),
            'categories' => CategoryResource::collection(
                Category::all('id', 'cat_name')
            )
        ]);
    }


    public function edit(Restaurant $restaurant)
    {
        return Inertia::render("Restaurant/Edit", [
            'restaurant' => new RestaurantResource($restaurant),
            'cities' => CityResource::collection(
                City::all('id', 'city_name')
            )
        ]);
    }


    public function update(UpdateRestaurantRequest $request, Restaurant $restaurant)
    {
        $fields = $request->validated();

        if ($request->hasFile('rest_logo')) {
            if ($restaurant['rest_logo'] !== null) {
                Storage::disk('public')->delete($restaurant['rest_logo']);
            }
            $fields['rest_logo'] = Storage::disk('public')
                ->put('restaurant_logo', $request->rest_logo);
        }
        if ($fields['rest_logo'] === null) {
            $fields['rest_logo'] = $restaurant['rest_logo'];
        }

        $restaurant->update($fields);
        return to_route('restaurant.show', $restaurant)
            ->with('status', 'restaurant-updated');
    }


    public function destroy(Request $request, Restaurant $restaurant)
    {
        dd("You should delete items image also!!");

        $request->validate([
            'password' => ['required', 'current_password'],
        ]);
        if ($restaurant['rest_logo'] !== null) {
            Storage::disk('public')->delete($restaurant['rest_logo']);
        }
        $restaurant->delete();
        return to_route('dashboard')->with('status', 'restaurant-deleted');
    }
}
