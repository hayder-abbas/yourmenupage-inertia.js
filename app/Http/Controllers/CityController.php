<?php

namespace App\Http\Controllers;

use App\Http\Resources\CityResource;
use App\Http\Resources\RestaurantResource;
use App\Models\City;
use Inertia\Inertia;

class CityController extends Controller
{
    public function index()
    {
        return Inertia::render('City/Index', [
            'cities' => CityResource::collection(
                City::all()
            )
        ]);
    }


    public function show(City $city)
    {
        return Inertia::render('City/Show', [
            'restaurants' => RestaurantResource::collection($city->restaurants),
            'cityName' => $city->city_name
        ]);
    }
}
