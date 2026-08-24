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
use App\Services\CreateRestaurant;
use App\Services\DeleteRestaurant;
use App\Services\UpdateRestaurant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class RestaurantController extends Controller
{
    public function create()
    {
        Gate::authorize('create', Restaurant::class);
        return inertia("Restaurant/Create", [
            'cities' => CityResource::collection(City::cached())
        ]);
    }

    public function store(StoreRestaurantRequest $request, CreateRestaurant $service)
    {
        Gate::authorize('create', Restaurant::class);
        $restaurant = $service->create($request);
        return redirect(route('restaurants.show', $restaurant))
            ->with('status', 'restaurant-created');
    }

    public function show(Restaurant $restaurant)
    {
        Gate::authorize('view', $restaurant);
        return inertia('Restaurant/Show', [
            'restaurant' => new RestaurantResource($restaurant),
            'items' => ItemResource::collection($restaurant->items),
            'categories' => CategoryResource::collection(Category::cached()),
            'can' => [
                'update' => Gate::allows('update', $restaurant),
                'manageItems' => Gate::allows('manageItems', $restaurant)
            ]
        ]);
    }

    public function edit(Restaurant $restaurant)
    {
        Gate::authorize('update', $restaurant);
        return inertia("Restaurant/Edit", [
            'restaurant' => new RestaurantResource($restaurant),
            'cities' => CityResource::collection(City::cached())
        ]);
    }

    public function update(UpdateRestaurantRequest $request, Restaurant $restaurant, UpdateRestaurant $service)
    {
        Gate::authorize('update', $restaurant);
        $service->update($request, $restaurant);
        return redirect(route('restaurants.show', $restaurant))
            ->with('status', 'restaurant-updated');
    }

    public function destroy(Request $request, Restaurant $restaurant, DeleteRestaurant $service)
    {
        Gate::authorize('delete', $restaurant);
        $service->delete($request, $restaurant);
        return redirect('dashboard')->with('status', 'restaurant-deleted');
    }
}
