<?php

namespace App\Http\Controllers;

use App\Http\Resources\CityResource;
use App\Http\Resources\RestaurantResource;
use App\Models\City;
use Illuminate\Support\Facades\Cache;

class CityController extends Controller
{
    public function index()
    {
        return inertia('City/Index', [
            'cities' => CityResource::collection(
                Cache::remember('cities', 3600, fn() => City::all())
            )
        ]);
    }


    public function show(City $city)
    {
        return inertia('City/Show', [
            'restaurants' => RestaurantResource::collection(
                $city->restaurants()->paginate(20)
            ),
            'cityName' => $city->city_name
        ]);
    }
}
