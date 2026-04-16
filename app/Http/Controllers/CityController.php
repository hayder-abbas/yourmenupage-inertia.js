<?php

namespace App\Http\Controllers;

use App\Http\Resources\CityResource;
use App\Http\Resources\RestaurantResource;
use App\Models\City;
use App\Models\Restaurant;
use Inertia\Inertia;

class CityController extends Controller
{
    public function index()
    {
        return Inertia::render('Cities/Index', [
            'cities' => CityResource::collection(
                City::all()
            )
        ]);
    }


    public function show(City $city)
    {
        return Inertia::render('Cities/Show', [
            'restaurants' => RestaurantResource::collection(
                Restaurant::where('city_id', $city->id)->get()
            ),

            'cityName' => $city->name
        ]);
    }
}
