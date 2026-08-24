<?php

namespace App\Http\Controllers;

use App\Http\Resources\CityResource;
use App\Http\Resources\RestaurantResource;
use App\Models\City;

class CityController extends Controller
{
    public function index()
    {
        return inertia('City/Index', [
            'cities' => CityResource::collection(City::cached())
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
