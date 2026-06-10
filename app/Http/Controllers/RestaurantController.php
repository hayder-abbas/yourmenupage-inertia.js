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
use App\Services\RestaurantService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Gate;
use Inertia\Inertia;

class RestaurantController extends Controller
{
    public function __construct(
        private RestaurantService $service
    ) {}


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
        $restaurant = $this->service->createRestaurant($request);
        return to_route('restaurants.show', $restaurant)
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
        $this->service->updateRestaurant($request, $restaurant);
        return to_route('restaurants.show', $restaurant)
            ->with('status', 'restaurant-updated');
    }


    public function destroy(Request $request, Restaurant $restaurant)
    {
        Gate::authorize('delete', $restaurant);
        $this->service->destroyRestaurant($request, $restaurant);
        return to_route('dashboard')->with('status', 'restaurant-deleted');
    }
}
